<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $posts = Post::latest()->paginate(7);
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
        $image = $data['image'];
        $imagePath = $image->store('post', 'public');
        $data['image'] = $imagePath;
        $data['slug'] = \Str::slug($data['title']);
        $data['user_id'] = auth()->id();

        $post = Post::create($data);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
