<?php

use App\Modules\Auth\Facebook\FacebookController;
use App\Modules\Auth\Login\LoginController;
use App\Modules\Auth\Logout\LogoutController;
use App\Modules\Auth\Register\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('register', RegisterController::class);
Route::post('login', LoginController::class);
Route::post('auth/facebook', FacebookController::class);

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::delete('logout', LogoutController::class);
    });
