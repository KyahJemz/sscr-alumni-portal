<?php

namespace Database\Seeders;

use App\Models\AdminInformation;
use App\Models\AlumniInformation;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminInformations = [
            [
                'user_id' => 2,
                'approved_by' => 2,
                'first_name' => 'CICT',
                'last_name' => 'Admin',
                'middle_name' => 'x',
                'department' => 'CICT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'approved_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'approved_by' => 2,
                'first_name' => 'Program Chair',
                'last_name' => 'Admin',
                'middle_name' => 'x',
                'department' => 'Program',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'approved_at' => Carbon::now(),
            ],
            [
                'user_id' => 4,
                'approved_by' => 2,
                'first_name' => 'Alumni Coordinator',
                'last_name' => 'Admin',
                'middle_name' => 'x',
                'department' => 'Alumni Coordinator',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'approved_at' => Carbon::now(),
            ],
        ];

        $alumniInformations = [
            [
                'user_id' => 1,
                'first_name' => 'Alumni',
                'last_name' => 'User',
                'course' => 'Bachelor of Science in Information Technology',
                'batch' => '2024',
                'middle_name' => 'x',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // foreach ($users as $user) {
        //     User::factory()->create($user);
        // }

        foreach ($adminInformations as $information) {
            AdminInformation::create($information);
        }

        foreach ($alumniInformations as $information) {
            AlumniInformation::create($information);
        }
    }
}
