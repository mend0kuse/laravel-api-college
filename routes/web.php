<?php

use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::post('video-upload', [ VideoController::class, 'uploadVideo' ])->name('store.video');
Route::post('likeVideo/{videoId}', [ VideoController::class, 'likeVideo' ])->name('video.like');
Route::post('dislikeVideo/{videoId}', [ VideoController::class, 'dislikeVideo' ])->name('video.dislike');

require __DIR__.'/auth.php';
