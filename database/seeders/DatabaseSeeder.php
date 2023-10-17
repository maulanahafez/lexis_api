<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $count = 10;
        User::factory()->count($count)->has(
            Story::factory(2)->has(
                Chapter::factory(2)
            )
        )->create();

        $chapters = Chapter::all();
        foreach ($chapters as $item) {
            Comment::factory()->count(rand(1, 5))->state([
                'chapter_id' => $item->id,
                'user_id' => rand(1, $count),
            ])->create();
            Like::factory()->count(rand(5, 10))->state([
                'chapter_id' => $item->id,
                'user_id' => rand(1, $count),
            ])->create();
        }
    }
}
