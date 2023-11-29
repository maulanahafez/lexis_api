<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uid' => fake()->uuid(),
            'username' => fake()->userName(),
            'email' => fake()->email(),
            'photoUrl' => fake()->imageUrl(150, 150),
            'name' => fake()->name(),
            'bio' => fake()->paragraph(),
            'story_preferences' => $this->story_preferences(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    // public function unverified(): static
    // {
    //     return $this->state(fn (array $attributes) => [
    //         'email_verified_at' => null,
    //     ]);
    // }

    private function story_preferences()
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
        $randomGenres = [];
        $numGenres = mt_rand(2, 5);
        shuffle($bookGenres);
        for ($i = 0; $i < $numGenres; $i++) {
            $randomGenres[] = $bookGenres[$i];
        }
        $genresString = implode('~', $randomGenres);
        return $genresString;
    }
}
