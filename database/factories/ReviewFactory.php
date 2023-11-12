<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => 0,
            'user_id' => 0,
            'title' => $this->faker->title(),
            'description' => $this->faker->paragraph(),
            'value' => $this->faker->numberBetween(0, 5),
        ];
    }
}
