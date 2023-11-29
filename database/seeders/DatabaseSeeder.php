<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Follow;
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
        User::factory()->count(10)->has(
            Story::factory(3)->has(
                Chapter::factory(2)
            )
        )->create();

        $data = $this->users();
        foreach ($data as $item) {
            User::factory()->state($item)->create();
        }

        $users = User::all();
        foreach ($users as $item) {
            Story::factory(3)->state(['user_id' => $item->id])->has(Chapter::factory(2))->create();
        }

        $chapters = Chapter::all();
        foreach ($chapters as $chapter) {
            foreach ($users as $user) {
                if (fake()->boolean()) {
                    Comment::factory()->count(1)->state([
                        'user_id' => $user->id,
                        'chapter_id' => $chapter->id
                    ])->create();
                    Like::factory()->count(1)->state([
                        'user_id' => $user->id,
                        'chapter_id' => $chapter->id
                    ])->create();
                }
            }
        }

        foreach ($users as $user1) {
            foreach ($users as $user2) {
                if (fake()->boolean(60) && $user1->id != $user2->id) {
                    Follow::factory()->count(1)->state([
                        'user_id' => $user1->id,
                        'follower_id' => $user2->id
                    ])->create();
                }
            }
        }
    }

    private function users()
    {
        $data = [
            [
                'uid' => 'cBF7qXkZdse3auxkf8hbtztiUx62',
                'name' => 'Maulana Hafez',
                'email' => 'maulanahafez00@gmail.com',
            ],
            [
                'uid' => 'xmAuYIx6guZuHBVDbdJmJLZa2wY2',
                'name' => 'MAULANA HAFEZ AHYATARA TEMPARIYAWAN 1',
                'email' => 'maulana.tempariyawan@mhs.unsoed.ac.id',
            ],
            [
                'uid' => 'vxXgXWE6b1YNWpFqX9sKJuRSAEY2',
                'name' => 'Maulana Hafez',
                'email' => 'maulanahafez1303@gmail.com',
            ],
            [
                'uid' => 'rPVuY2BVcVNmwH8SPMuVGvtaqDj1',
                'name' => 'Rakan Lhotlan',
                'email' => 'rakanmainnn@gmail.com',
            ],
            [
                'uid' => 'm2rdRwkRMZS1hHh6IKe3dnaZARZ2',
                'name' => 'AHITA BISMA ADLULA 1',
                'email' => 'ahita.adlula@mhs.unsoed.ac.id',
            ],
            [
                'uid' => 'Qi111aoTnKZXaRfJRDMgWPSGs9q1',
                'name' => 'Ahita Bisma A',
                'email' => 'ahitabisma21@gmail.com',
            ],
            [
                'uid' => 'QpYu5YYuEqhgAFpvw1cRyd7I1Fk1',
                'name' => 'Nihayatur Rahmah',
                'email' => 'afspraakhyrm@gmail.com',
            ],
            [
                'uid' => 'AMegI18mvDXpmfliVtIjzDnNxdN2',
                'name' => 'Usriyatul Khamimah',
                'email' => 'khamimahusriyatul@gmail.com',
            ],
        ];

        return $data;
    }
}
