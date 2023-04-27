<?php

namespace App\Http\Requests;

use App\Models\Site;
use App\Models\UserAccessToken;
use Illuminate\Foundation\Http\FormRequest;

class VerifyAccessRequest extends FormRequest
{
    protected ?UserAccessToken $userAccessToken;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $site = Site::query()
            ->where('app_key', $this->app_key)
            ->firstOrFail();
        $this->userAccessToken = UserAccessToken::query()
            ->where('access_token', $this->token)
            ->firstOrFail();
        return $site->id === $this->userAccessToken->site_id && $site->domain === $this->getHost();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function getUserAccessToken(): UserAccessToken
    {
        return $this->userAccessToken;
    }
}
