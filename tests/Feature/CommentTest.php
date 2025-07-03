<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_add_comment_to_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/posts/{$post->id}/comments", [
                'content' => 'This is a test comment.',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'content',
                    'user' => ['id', 'name'],
                    'created_at',
                    'updated_at',
                ]
            ]);

        $this->assertDatabaseHas('comments', [
            'content' => 'This is a test comment.',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_add_comment()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->postJson("/api/posts/{$post->id}/comments", [
            'content' => 'This is a test comment.',
        ]);

        $response->assertStatus(401);
    }

}
