<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

     public function test_authenticated_user_can_create_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/posts', [
                'title' => 'Test Post',
                'content' => 'This is a test post content.',
                'category_id' => $category->id,
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'content',
                    'user' => ['id', 'name'],
                    'category' => ['id', 'name'],
                    'comments_count',
                    'created_at',
                    'updated_at',
                ]
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_create_post()
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(401);
    }

    public function test_can_view_post_with_comments()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $comments = Comment::factory()->count(3)->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $response = $this->getJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'content',
                    'user' => ['id', 'name'],
                    'category' => ['id', 'name'],
                    'comments' => [
                        '*' => [
                            'id',
                            'content',
                            'user' => ['id', 'name'],
                            'created_at',
                            'updated_at',
                        ]
                    ],
                    'created_at',
                    'updated_at',
                ]
            ])
            ->assertJsonCount(3, 'data.comments');
    }
    
}
