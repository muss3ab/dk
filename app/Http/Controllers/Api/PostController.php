<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostDetailResource;
use App\Models\Post;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $posts = Post::with(['user', 'category'])
            ->withCount('comments')
            ->latest()
            ->get();

        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
        ]);

        $post->load(['user', 'category']);

        return new PostResource($post);
    }

    public function show(Post $post)
    {
        $post->load(['user', 'category', 'comments.user']);

        return new PostDetailResource($post);
    }

    public function update(StorePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->validated());
        $post->load(['user', 'category']);

        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
