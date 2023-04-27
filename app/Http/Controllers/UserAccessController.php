<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreUserAccessRequest, VerifyAccessRequest};
use App\Models\UserAccessToken;
use App\Services\MultiFactorService;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\{JsonResponse, Request};

class UserAccessController extends Controller
{
    public function store(StoreUserAccessRequest $request, MultiFactorService $multiFactorService): JsonResponse
    {
        $recoveryCodes = $multiFactorService->generateCode();
        $secret = $multiFactorService->generateSecretKey();
        $token = generateToken();

        UserAccessToken::create([
            'site_id' => $request->getSite()->id,
            'access_token' => $token,
            'mfa_secret' => encrypt($secret),
            'mfa_recovery_codes' => encrypt($recoveryCodes),
        ]);

        return response()->json([
            'success' => true,
            'qr_code' => [
                'svg' => $multiFactorService->twoFactorQrCodeSvg('company', $token, $secret),
            ],
            'recovery_codes' => $recoveryCodes,
            'token' => $token,
        ]);
    }

    public function verify(VerifyAccessRequest $request, MultiFactorService $multiFactorService): JsonResponse
    {
        $userAccessToken = $request->getUserAccessToken();
        $validated = $request->validate([
            'code' => ['required', 'numeric'],
        ]);

        $secret = decrypt($userAccessToken->mfa_secret);

        if (!$multiFactorService->verify($secret, $validated['code'])) {
            throw ValidationException::withMessages([
                'challenge' => 'The provided code was invalid.'
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(VerifyAccessRequest $request)
    {
       $request->getUserAccessToken()->delete();
        return response()->json(['success' => true]);
    }
}
