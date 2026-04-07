<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->creator(),
            'title' => fake()->unique()->sentence(4),
            'description' => fake()->paragraph(),
            'youtube_id' => 'dQw4w9WgXcQ',
            'thumbnail_url' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
            'views' => fake()->numberBetween(0, 5000),
            'is_featured' => false,
            'is_published' => true,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
