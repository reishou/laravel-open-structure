<?php

use App\Modules\Auth\Register\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('register', RegisterController::class);
