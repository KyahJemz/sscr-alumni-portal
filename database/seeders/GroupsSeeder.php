<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clubs = [
            [
                'created_by' => 4,
                'name' => 'Basketball Club',
                'description' => 'A club for basketball enthusiasts.',
                'image' => 'basketball_club.jpg'
            ],
            [
                'created_by' => 4,
                'name' => 'Chess Club',
                'description' => 'A club for chess lovers.',
                'image' => 'chess_club.jpg'
            ],
            [
                'created_by' => 4,
                'name' => 'Dance Club',
                'description' => 'A club for those who love to dance.',
                'image' => 'dance_club.jpg'
            ],
            [
                'created_by' => 4,
                'name' => 'Music Club',
                'description' => 'A club for musicians and music lovers.',
                'image' => 'music_club.jpg'
            ],
            [
                'created_by' => 4,
                'name' => 'Art Club',
                'description' => 'A club for artists and creative minds.',
                'image' => 'art_club.jpg'
            ],
            [
                'created_by' => 4,
                'name' => 'Drama Club',
                'description' => 'A club for aspiring actors and theater enthusiasts.',
                'image' => 'drama_club.jpg'
            ],
            [
                'created_by' => 4,
                'name' => 'Photography Club',
                'description' => 'A club for photographers and visual storytellers.',
                'image' => 'photography_club.jpg'
            ],
            [
                'created_by' => 4,
                'name' => 'Coding Club',
                'description' => 'A club for coders and tech enthusiasts.',
                'image' => 'coding_club.jpg'
            ],
            [
                'created_by' => 4,
                'name' => 'Science Club',
                'description' => 'A club for science enthusiasts and researchers.',
                'image' => 'science_club.jpg'
            ],
            [
                'created_by' => 4,
                'name' => 'Math Club',
                'description' => 'A club for math lovers and problem solvers.',
                'image' => 'math_club.jpg'
            ],
        ];

        foreach ($clubs as $club) {
            Group::create($club);
        }
    }
}
