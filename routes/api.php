<?php

use App\Http\Controllers\HashtagController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// pencarian users
Route::get('/users/search', [HomeController::class, 'searchUsers']);

// pencaraian hashtag
Route::get('/api/hashtag', [HashtagController::class, 'searchHashtag']);

// Route::get('users', [HomeController::class, 'uploadTest'])->name('upload.test');
?>
