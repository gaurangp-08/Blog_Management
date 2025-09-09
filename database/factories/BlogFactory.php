<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraphs(3, true),
            'user_id' => User::factory(),
            'likes_count' => fake()->numberBetween(0, 100),
        ];
    }
}