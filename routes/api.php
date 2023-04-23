<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAccessController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/generate', [UserAccessController::class, 'store'])->name('api.generate');
Route::post('/verify/{token}/site/{app_key}', [UserAccessController::class, 'verify'])->name('api.verify');
Route::delete('/delete/{token}', [UserAccessController::class, 'destroy'])->name('api.delete');
