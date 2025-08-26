<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'description' => fake()->paragraphs(asText: true),
            'price' => fake()->randomNumber() * 1000,
            'file' => Str::random(20) . '.zip',
            'user_id' => fake()->randomNumber(3, true),
            'category_id' => fake()->randomNumber(4, true),
        ];
    }
}
