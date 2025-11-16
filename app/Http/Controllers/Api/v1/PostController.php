<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResources;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $posts = PostResources::collection($user->posts()->paginate(15));
        return PostResources::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        //  return $data;
        $data['author_id'] = $request->user()->id;
        $post = Post::create($data);
        return response()->json(new PostResources($post), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

        
        return new PostResources($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required | string | max:20',
            'body' => 'required | string'
        ]);

        $post->update($data);
        return new PostResources($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
    }
}
