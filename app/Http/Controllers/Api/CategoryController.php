<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Http\Resources\PostResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function posts(Category $category)
    {
        $posts = $category->posts()
            ->with(['user', 'category'])
            ->withCount('comments')
            ->latest()
            ->get();

        return PostResource::collection($posts);
    }
}
