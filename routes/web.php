<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FileController;

Route::get('/', function () {
    return redirect(route('upload-file-view'));
});

Route::get('/upload', [FileController::class, 'index'])->name('upload-file-view');
Route::post('/upload', [FileController::class, 'uploadFile'])->name('upload-file-post');
