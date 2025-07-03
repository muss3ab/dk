<?php

namespace Database\Seeders;


use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users
        $users = User::factory(10)->create();

        // Create categories
        $categories = Category::factory(5)->create();

        // Create posts
        $posts = Post::factory(20)->create([
            'user_id' => $users->random()->id,
            'category_id' => $categories->random()->id,
        ]);

        // Create comments
        Comment::factory(50)->create([
            'user_id' => $users->random()->id,
            'post_id' => $posts->random()->id,
        ]);

    }
}
