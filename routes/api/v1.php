<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\Api\V1\PostController;
use App\Http\Controllers\Image\Api\V1\ImageController;

//TODO: because the auth section has not developed yet, I have removed middleware section
Route::prefix('images')->group(function () {
    Route::get('/', [ImageController::class, 'index'])
        ->name('admin.image.index');
    Route::get('/{image}', [ImageController::class, 'show'])
        ->name('admin.image.show');
    Route::post('/', [ImageController::class, 'store'])
        ->name('admin.image.store');
    Route::put('/', [ImageController::class, 'update'])
        ->name('admin.image.update');
    Route::delete('/', [ImageController::class, 'destroy'])
        ->name('admin.image.destroy');
});


Route::prefix('posts')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [PostController::class, 'index'])
        ->name('admin.post.index');
    Route::get('/{post}', [PostController::class, 'show'])
        ->name('admin.post.show');
    Route::post('/', [PostController::class, 'store'])
        ->name('admin.post.store');
    Route::put('/', [PostController::class, 'update'])
        ->name('admin.post.update');
    Route::delete('/', [PostController::class, 'destroy'])
        ->name('admin.post.destroy');
    Route::delete('/{post}/change-status', [PostController::class, 'changeStatus'])
        ->name('admin.post.changeStatus');
});
