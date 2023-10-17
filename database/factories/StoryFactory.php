<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Story>
 */
class StoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'user_id' => fake()->name(),
            'title' => fake()->sentence(),
            'genre' => $this->genre(),
            'description' => fake()->paragraph(),
            'cover_path' => fake()->imageUrl(160, 160),
            'is_published' => fake()->boolean(),
        ];
    }

    private function genre()
    {
        $bookGenres = [
            "Mystery",
            "Science Fiction",
            "Fantasy",
            "Romance",
            "Thriller",
            "Horror",
            "Historical Fiction",
            "Non-Fiction",
            "Biography",
            "Adventure"
        ];

        return $bookGenres[rand(0, 9)];
    }
}
