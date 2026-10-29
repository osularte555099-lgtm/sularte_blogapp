<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // READ ALL
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    // SHOW CREATE FORM
    public function create()
    {
        return view('posts.create');
    }

    // STORE DATA
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        Post::create($data);

        return redirect()->route('posts.index')
                         ->with('success', 'Post created successfully.');
    }

    // SHOW SINGLE POST
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // SHOW EDIT FORM
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    // UPDATE DATA
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $post->update($data);

        return redirect()->route('posts.index')
                         ->with('success', 'Post updated successfully.');
    }

    // DELETE DATA
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
                         ->with('success', 'Post deleted successfully.');
    }
}