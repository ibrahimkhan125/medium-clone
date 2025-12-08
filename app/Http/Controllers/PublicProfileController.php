<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function show(User $user)
    {
        // Logic to retrieve and display the public profile of the user with the given username
        // For example:
        // $user = User::where('username', $username)->firstOrFail();
        // return view('public_profile', compact('user'));
        $posts = $user->posts()
                    ->where('published_at', '<=', now())->latest()->paginate();
        return view('profile.show', ['user' => $user, 'posts' => $posts]);
    }
}
