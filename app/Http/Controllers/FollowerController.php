<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function followUnfollow(User $user)
    {
        // Toggle follow/unfollow can be written in two ways one is below and commented
        // auth()->user()->following()->toggle($user);
        // Another way
        $user->followers()->toggle(auth()->user());
        return response()->json(
            [
                "followersCount"=> $user->followers()->count(),
            ]
        );
    }
}
