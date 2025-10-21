<?php

use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(PostController::class)->group(function () {
        Route::get('/','index')->name('dashboard');
        Route::get('/post/create','create')->name('post.create');
        Route::post('/post/store','store')->name('post.store');
        Route::get('/@{username}/{post:slug}','show')->name('post.show');
        Route::post('/follow/{user}',[FollowerController::class, 'followUnfollow']);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/@{user:username}', [App\Http\Controllers\PublicProfileController::class, 'show'])->name('profile.show');

require __DIR__.'/auth.php';
