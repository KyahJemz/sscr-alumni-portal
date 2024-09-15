<?php

namespace Database\Seeders;

use App\Models\User;
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
                'name' => 'Alumni User',
                'email' => 'program_chair@test.com',
                'username' => 'ProgramChair',
                'role' => 'program_chair',
            ],
            [
                'name' => 'Alumni User',
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
