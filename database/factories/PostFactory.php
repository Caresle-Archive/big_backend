<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first()->id;
        $category = Category::inRandomOrder()->first()->id;
        $review_id = Review::inRandomOrder()->first()->id;

        return [
            'name' => $this->faker->title(),
            'description' => $this->faker->paragraph(),
            // 'user_id' => $user,
            // 'category_id' => $category,
            // 'review_id' => $review_id,
        ];
    }
}
