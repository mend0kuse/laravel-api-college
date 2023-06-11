<?php

use App\Http\Controllers\VideoController;
use App\Http\Controllers\CommentsController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('videos', [ VideoController::class, 'getVideos' ])->name('store.getVideos');
Route::get('user-videos/{userId}', [ VideoController::class, 'getVideosByUserId' ])->name('store.getVideosByUserId');
Route::post('video-upload', [ VideoController::class, 'uploadVideo' ])->name('store.video');
Route::post('likeVideo/{videoId}', [ VideoController::class, 'likeVideo' ])->name('video.like');
Route::post('dislikeVideo/{videoId}', [ VideoController::class, 'dislikeVideo' ])->name('video.dislike');

Route::post('commentVideo/{videoId}', [ CommentsController::class, 'addCommentToVideo' ])->name('video.addCommentToVideo');

require __DIR__.'/auth.php';
