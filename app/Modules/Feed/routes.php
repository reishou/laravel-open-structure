<?php

use App\Modules\Feed\GetFeeds\GetFeedsController;
use App\Modules\Feed\SearchImage\SearchImageController;
use App\Modules\Feed\SearchMap\SearchMapController;
use App\Modules\Feed\SearchUser\SearchUserController;
use Illuminate\Support\Facades\Route;

Route::get('feeds', GetFeedsController::class);
Route::get('search/image', SearchImageController::class);
Route::get('search/map', SearchMapController::class);
Route::get('search/user', SearchUserController::class);
