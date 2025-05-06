<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Admin Desa',
                'nik' => '1234567890',
                'email' => 'admin@desa.com',
                'password' => Hash::make('admin@123'),
                'role' => 'admin',
                'verified_is' => true
            ],
            [
                'nama' => 'Kepala Desa',
                'nik' => '0987654321',
                'email' => 'kepala@desa.com',
                'password' => Hash::make('kepala@123'),
                'role' => 'kepala desa',
                'verified_is' => true
            ],
            [
                'nama' => 'User Desa',
                'nik' => '1122334455',
                'email' => 'user@desa.com',
                'password' => Hash::make('user@123'),
                'role' => 'user',
                'verified_is' => true
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
