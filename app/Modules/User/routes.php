<?php

use App\Modules\User\FollowUser\FollowUserController;
use App\Modules\User\GetFollowers\GetFollowersController;
use App\Modules\User\GetFollowing\GetFollowingController;
use App\Modules\User\GetProfile\GetProfileController;
use App\Modules\User\UnfollowUser\UnfollowUserController;
use App\Modules\User\UpdateProfile\UpdateProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('users/{id}')
    ->group(function () {
        Route::get('profile', GetProfileController::class);
        Route::get('followers', GetFollowersController::class);
        Route::get('following', GetFollowingController::class);
        Route::middleware(['auth:sanctum'])
            ->group(function () {
                Route::patch('profile', UpdateProfileController::class);
                Route::post('follow', FollowUserController::class);
                Route::delete('follow', UnfollowUserController::class);
            });
    });
