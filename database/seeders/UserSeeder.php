<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['username' => 'admin'], [
            'name' => 'Admin R27',
            'username' => 'admin',
            'email' => 'admin@r27.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::updateOrCreate(['username' => 'user1'], [
            'name' => 'User R27',
            'username' => 'user1',
            'email' => 'user@r27.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}