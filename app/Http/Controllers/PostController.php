<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->with(['user', 'likes'])->paginate(20); //returns all posts

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'body' => 'required'
        ]);

        $request->user()->posts()->create([
            'body' => $request->body
        ]);


        return back();

    }

    public function destroy (Post $post, Request $request)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return back();
    }
}
