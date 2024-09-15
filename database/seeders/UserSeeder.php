<?php

namespace Database\Seeders;

use App\Models\AdminInformation;
use App\Models\AlumniInformation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Alumni User',
                'email' => 'alumni@test.com',
                'username' => 'Alumni',
                'role' => 'alumni',
            ],
            [
                'name' => 'CICT Admin',
                'email' => 'cict_admin@test.com',
                'username' => 'cict',
                'role' => 'cict_admin',
            ],
            [
                'name' => 'Program Chair',
                'email' => 'program_chair@test.com',
                'username' => 'ProgramChair',
                'role' => 'program_chair',
            ],
            [
                'name' => 'Alumni Coordinator',
                'email' => 'alumni_coordinator@test.com',
                'username' => 'AlumniCoordinator',
                'role' => 'alumni_coordinator',
            ],
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }

    }
}
