<?php

use App\Modules\Post\CommentOnPost\CommentOnPostController;
use App\Modules\Post\CreatePost\CreatePostController;
use App\Modules\Post\DeletePost\DeletePostController;
use App\Modules\Post\DeletePostComment\DeletePostCommentController;
use App\Modules\Post\GetPostComments\GetPostCommentsController;
use App\Modules\Post\GetPostDetail\GetPostDetailController;
use App\Modules\Post\LikePost\LikePostController;
use App\Modules\Post\LikePostComment\LikePostCommentController;
use App\Modules\Post\UnlikePost\UnlikePostController;
use App\Modules\Post\UnlikePostComment\UnlikePostCommentController;
use App\Modules\Post\UpdatePost\UpdatePostController;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')
    ->group(function () {
        Route::post('/', CreatePostController::class)
            ->middleware(['auth:sanctum']);
        Route::prefix('{id}')
            ->group(function () {
                Route::get('comments', GetPostCommentsController::class);
                Route::get('/', GetPostDetailController::class);

                Route::middleware(['auth:sanctum'])
                    ->group(function () {
                        Route::patch('/', UpdatePostController::class);
                        Route::delete('/', DeletePostController::class);
                        Route::post('like', LikePostController::class);
                        Route::delete('like', UnlikePostController::class);
                        Route::post('comments', CommentOnPostController::class);

                        Route::prefix('comments/{commentId}')
                            ->middleware(['auth:sanctum'])
                            ->group(function () {
                                Route::post('like', LikePostCommentController::class);
                                Route::delete('like', UnlikePostCommentController::class);
                                Route::delete('/', DeletePostCommentController::class);
                            });
                    });
            });
    });
