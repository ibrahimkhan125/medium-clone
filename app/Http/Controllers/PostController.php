<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostEditRequest;
use App\Http\Requests\PostRequest;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd('here');
        // $favPlayer = DB::table('players as p')
        //     ->join('teams as t', 't.id', '=', 'p.team_id')
        //     ->leftJoin('players as fp', 'fp.id', '=', 'p.favorite_player')
        //     ->select('p.player_name', 't.team_name',
        //     'fp.player_name as fav_player_name')
        //     ->get();

        //     dd($favPlayer);
        // \DB::listen(function ($query) {
        //     \Log::info($query->sql);
        // });
        $posts = Post::where('published_at', '<=', now())->with(['user', 'media'])->withCount('claps')->latest();
        if (Auth::check()) {
            $current_user_following = auth()->user()->following()->pluck('users.id');
            $current_user_following->push(auth()->id());
            $posts->whereIn('user_id', $current_user_following);
        }
        $posts = $posts->simplePaginate(7);

        return view("post.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get()->toArray();
        return view("post.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $data = $request->validated();
        // $image = $data['image'];
        // $imagePath = $image->store('post', 'public');
        // $data['image'] = $imagePath;
        $data['slug'] = \Str::slug($data['title']);
        $data['user_id'] = auth()->id();

        $post = Post::create($data);
        $post->addMediaFromRequest('image')->toMediaCollection();
        // dd($post);
        event(new \App\Events\ArticlePublished($post));
        return redirect()->route('dashboard')->with('success', 'Post created successfully.');
        // dd($request->all());
        // $post = Post::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($username, Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if($post->user_id != auth()->id()){
            abort(403, 'Unauthorized action.');
        }
        $categories = Category::get()->toArray();
        // dd($post);
        return view("post.edit", compact("post", "categories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostEditRequest $request, Post $post)
    {
        // dd()
        // dd('here', $request->all(), $post);
        if($post->user_id != auth()->id()){
            abort(403, 'Unauthorized action.');
        }
        $data = $request->validated();
        $post->update($data);
        if($request->hasFile('image')){
            $post->addMediaFromRequest('image')->toMediaCollection();
        }
        return redirect()->route('dashboard')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if($post->user_id != auth()->id()){
            abort(403, 'Unauthorized action.');
        }
        $post->delete();
        return redirect()->route('dashboard')->with('success', 'Post deleted successfully.');
    }

    public function postsByCategory(Category $category)
    {
        $query = $category
                    ->posts()
                    ->where('published_at', '<=', now())
                    ->with(['user', 'media'])->withCount('claps');
        if (Auth::check()) {
            $current_user_following = auth()->user()->following()->pluck('users.id');
            $current_user_following->push(auth()->id());
            $query->whereIn('user_id', $current_user_following);
        }
        $posts = $query->latest()->simplePaginate(7);
        return view("post.index", compact("posts"));
    }
    public function myPosts()
    {
        $posts = Auth::user()->posts()
            ->with(['user', 'media'])->withCount('claps')
            ->latest()->simplePaginate(5);
        return view("post.index", compact("posts"));
    }
}
