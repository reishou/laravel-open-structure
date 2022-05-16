<?php

use App\Modules\File\GeneratePresigned\GeneratePresignedController;
use Illuminate\Support\Facades\Route;

Route::prefix('files')->middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('presigned', GeneratePresignedController::class);
    });
