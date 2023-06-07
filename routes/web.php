<?php

use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::post('video-upload', [ VideoController::class, 'uploadVideo' ])->name('store.video');
Route::get('video-upload', [ VideoController::class, 'getVideoUploadForm' ])->name('get.video.upload');
require __DIR__.'/auth.php';
