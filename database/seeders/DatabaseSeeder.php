<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Post;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\FactoryBuilder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)
            ->hasPosts(20, fn (array $attribtues, User $user) => ['user_id' => $user->id])
            ->has(Review::factory()->count(20)->state(function (array $attributes, User $user) {
                $post = Post::whereUserId($user->id)->inRandomOrder()->first();
                return [
                    'user_id' => $post->user_id,
                    'post_id' => $post->id,
                ];
            }))
            ->create();
    }
}
