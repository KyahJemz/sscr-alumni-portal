<?php

namespace Database\Seeders;

use App\Models\Hobbies;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HobbiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hobbies = [
            [
                'name' => 'Basketball',
                'description' => 'A sport played by two teams of five players each on a rectangular court.',
                'category' => 'Sports',
                'image' => 'basketball.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Chess',
                'description' => 'A strategic board game played on an 8x8 grid with 16 pieces per player.',
                'category' => 'Games',
                'image' => 'chess.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Drawing',
                'description' => 'The art or technique of creating visual images by marking a surface with a pencil, pen, or other tools.',
                'category' => 'Art',
                'image' => 'drawing.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Gardening',
                'description' => 'The practice of growing and cultivating plants as part of horticulture.',
                'category' => 'Outdoor',
                'image' => 'gardening.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Photography',
                'description' => 'The art or practice of taking and processing photographs.',
                'category' => 'Art',
                'image' => 'photography.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Cooking',
                'description' => 'The practice of preparing food by combining, mixing, and heating ingredients.',
                'category' => 'Skills',
                'image' => 'cooking.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Coding',
                'description' => 'The process of writing instructions for computers using programming languages.',
                'category' => 'Skills',
                'image' => 'coding.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Traveling',
                'description' => 'The act of going from one place to another, often to explore new destinations.',
                'category' => 'Adventure',
                'image' => 'traveling.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Music',
                'description' => 'The art of arranging sounds in time to produce a composition through melody, harmony, rhythm, and timbre.',
                'category' => 'Art',
                'image' => 'music.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Yoga',
                'description' => 'A group of physical, mental, and spiritual practices aimed at achieving a state of tranquility and balance.',
                'category' => 'Fitness',
                'image' => 'yoga.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($hobbies as $hobby) {
            Hobbies::factory()->create($hobby);
        }
    }
}
