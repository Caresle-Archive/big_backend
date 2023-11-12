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
        return [
            'name' => $this->faker->title(),
            'description' => $this->faker->text(),
            'user_id' => 10,
            'category_id' => Category::factory(),
        ];
    }
}
