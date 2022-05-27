<?php

use App\Modules\Auth\ForgetPassword\ForgetPasswordController;
use App\Modules\Auth\Login\LoginController;
use App\Modules\Auth\LoginFacebook\LoginFacebookController;
use App\Modules\Auth\Logout\LogoutController;
use App\Modules\Auth\Register\RegisterController;
use App\Modules\Auth\ResetPassword\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::post('register', RegisterController::class);
Route::post('login', LoginController::class);
Route::post('auth/facebook', LoginFacebookController::class);
Route::post('auth/password/forget', ForgetPasswordController::class);
Route::post('auth/password/reset', ResetPasswordController::class);

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::delete('logout', LogoutController::class);
    });
