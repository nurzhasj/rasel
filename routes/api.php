<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\ForgotPasswordController;
use Modules\Auth\Controllers\LoginController;
use Modules\Auth\Controllers\RegisterController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('login', [LoginController::class, 'login'])->name('login');
//Route::post('register', [RegisterController::class, 'register'])->name('register');
//Route::post('verify-phone', [RegisterController::class, 'verifyPhoneNumber'])->name('verify');
//Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot-password');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('set-password', [RegisterController::class, 'setPassword'])->name('set-password');
});
