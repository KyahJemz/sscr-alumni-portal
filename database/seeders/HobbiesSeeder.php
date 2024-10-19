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
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila'),
            ],
            [
                'name' => 'Chess',
                'description' => 'A strategic board game played on an 8x8 grid with 16 pieces per player.',
                'category' => 'Games',
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila'),
            ],
            [
                'name' => 'Drawing',
                'description' => 'The art or technique of creating visual images by marking a surface with a pencil, pen, or other tools.',
                'category' => 'Art',
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila'),
            ],
            [
                'name' => 'Gardening',
                'description' => 'The practice of growing and cultivating plants as part of horticulture.',
                'category' => 'Outdoor',
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila'),
            ],
            [
                'name' => 'Photography',
                'description' => 'The art or practice of taking and processing photographs.',
                'category' => 'Art',
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila'),
            ],
            [
                'name' => 'Cooking',
                'description' => 'The practice of preparing food by combining, mixing, and heating ingredients.',
                'category' => 'Skills',
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila'),
            ],
            [
                'name' => 'Coding',
                'description' => 'The process of writing instructions for computers using programming languages.',
                'category' => 'Skills',
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila'),
            ],
            [
                'name' => 'Traveling',
                'description' => 'The act of going from one place to another, often to explore new destinations.',
                'category' => 'Adventure',
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila'),
            ],
            [
                'name' => 'Music',
                'description' => 'The art of arranging sounds in time to produce a composition through melody, harmony, rhythm, and timbre.',
                'category' => 'Art',
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila'),
            ],
            [
                'name' => 'Yoga',
                'description' => 'A group of physical, mental, and spiritual practices aimed at achieving a state of tranquility and balance.',
                'category' => 'Fitness',
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila'),
            ],
        ];

        foreach ($hobbies as $hobby) {
            Hobbies::factory()->create($hobby);
        }
    }
}
