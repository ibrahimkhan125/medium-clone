<?php

use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckSuspended;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware(['auth', 'verified', CheckSuspended::class])->group(function () {
    Route::controller(PostController::class)->group(function () {
        Route::get('/','index')->name('dashboard');
        Route::get('/post/create','create')->name('post.create');
        Route::post('/post/store','store')->name('post.store');
    });
    Route::post('/follow/{user}',[FollowerController::class, 'followUnfollow']);
    Route::get('/payment', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/@{user:username}', [App\Http\Controllers\PublicProfileController::class, 'show'])->name('profile.show');
Route::get('/@{username}/{post:slug}',[PostController::class, 'show'])->name('post.show');

Route::get('/google/auth/redirect', function () {
    return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->with(['access_type' => 'offline', 'prompt' => 'consent'])->redirect();
})->name('google.redirect');

Route::get('/google/auth/callback', function () {
    $google_user = Socialite::driver('google')->user();
    $user = User::firstOrNew([
        'email' => $google_user->email,
    ]);
    if(!$user->exists){
        $user->name = $google_user->name;
        $user->email = $google_user->email;
        $user->username = User::generateUniqueUsername($google_user->name);
        $user->password = 'password';
        $user->email_verified_at = now();
        $user->google_token = $google_user->token;
        $user->google_refresh_token = $google_user->refreshToken;
        $user->image = $google_user->avatar;
    }
    $user->google_id = $google_user->id;
    $user->google_token = $google_user->token;
    $user->google_refresh_token = $google_user->refreshToken;
    $user->image = $google_user->avatar;
    $user->save();
    // User::updateOrCreate([
    //     'email' => $google_user->email,
    // ], [
    //     'name' => $google_user->name,
    //     'username' => User::generateUniqueUsername($google_user->name),
    //     'password' => 'password',
    //     'email_verified_at' => now(),
    //     'google_token' => $google_user->token,
    //     'google_refresh_token' => $google_user->refreshToken,
    //     'image' => $google_user->avatar,
    // ]);
    Auth::login($user);
    return redirect('/');
});

Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

require __DIR__.'/auth.php';
