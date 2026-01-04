<?php

// database/seeders/UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin islamicAdvanture',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Admin No. 1, Jakarta',
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Customer Users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'no_telepon' => '081234567891',
            'alamat' => 'Jl. Customer No. 1, Bandung',
            'role' => 'customer',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'no_telepon' => '081234567892',
            'alamat' => 'Jl. Customer No. 2, Surabaya',
            'role' => 'customer',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
