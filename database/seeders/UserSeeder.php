<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'phone_number' => '08212345678',
            'password' => Hash::make('superadmin'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        // Membuat Admin
        User::create([
            'name' => 'Admin Konser',
            'email' => 'admin@example.com',
            'phone_number' => '08221345678',
            'password' => Hash::make('admin111'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
