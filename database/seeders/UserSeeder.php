<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin R27',
            'username' => 'admin',
            'email' => 'admin@r27creative.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Participant R27',
            'username' => 'participant',
            'email' => 'participant@r27creative.com',
            'password' => Hash::make('participant123'),
            'role' => 'participant',
        ]);
    }
}