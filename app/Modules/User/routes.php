<?php

use App\Modules\User\GetProfile\GetProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('users/{id}')
    ->group(function () {
        Route::get('profile', GetProfileController::class);
    });
