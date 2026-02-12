<?php

namespace App\Http\Controllers;

use App\Models\Clap;
use App\Models\Post;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class ClapController extends Controller
{
    /**
     * This function handles the clap action for a post by a user.
     */
    function clap(Post $post)
    {
        // Logic to record a clap for the post by the user
        // This could involve updating a database table that tracks claps

        // For demonstration, we'll just return a success response
        try{

            $userAlreadyClapped = auth()->user()?->hasClappedThisPost($post);
            if(!empty($userAlreadyClapped)){
                $post->claps()->where('user_id', auth()->id())->delete();
            }else{
                $post->claps()->create([
                    'user_id' => auth()->id()
                ]);
            }
            return response()->json(['count' => $post->claps()->count()], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'An error occurred while processing your clap.'], 500);
        }
    }
}
