<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Url>
 */
class UrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url' => fake()->url(),
            'visits' => rand(min: 0, max: 100),
        ];
    }

    /**
     * Mark a URL as visited.
     */
    public function visited(): static
    {
        return $this->state(fn (array $attributes) => [
            'visits' => ++$attributes['visits'],
            'last_visited_at' => now(),
        ]);
    }

    /**
     * Mark the URL as not visited.
     */
    public function unvisited(): static
    {
        return $this->state(fn (array $attributes) => [
            'visits' => 0,
            'last_visited_at' => null,
        ]);
    }
}
