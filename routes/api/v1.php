<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\Api\V1\PostController;
use App\Http\Controllers\Image\Api\V1\ImageController;

Route::prefix('images')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ImageController::class, 'index']);
    Route::get('/{image}', [ImageController::class, 'show']);
    Route::post('/', [ImageController::class, 'store']);
    Route::put('/', [ImageController::class, 'update']);
    Route::delete('/', [ImageController::class, 'destroy']);
});


Route::prefix('posts')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [PostController::class, 'index']);
    Route::get('/{post}', [PostController::class, 'show']);
    Route::post('/', [PostController::class, 'store']);
    Route::put('/', [PostController::class, 'update']);
    Route::delete('/', [PostController::class, 'destroy']);
    Route::delete('/{post}/change-status', [PostController::class, 'changeStatus']);
});
