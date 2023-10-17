<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chapter>
 */
class ChapterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'story_id' => fake()->name(),
            'title' => fake()->sentence(),
            'order_num' => fake()->randomNumber(2),
            'content' => fake()->randomHtml(10),
            'is_published' => fake()->boolean(),
        ];
    }
}
