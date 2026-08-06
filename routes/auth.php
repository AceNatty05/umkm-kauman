<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    // OTP Verification
    Route::get('verify-otp', [OtpController::class, 'show'])
        ->name('otp.verify');

    Route::post('verify-otp', [OtpController::class, 'verify'])
        ->name('otp.verify.submit');

    Route::post('resend-otp', [OtpController::class, 'resend'])
        ->name('otp.resend');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
