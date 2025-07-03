<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{

  public function store(StoreCommentRequest $request, Post $post)
    {
        $comment = Comment::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'post_id' => $post->id,
        ]);
        
        return new CommentResource($comment->load('user'));
    }
}
