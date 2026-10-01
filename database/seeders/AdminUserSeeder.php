<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'username' => 'admin',
            ],
            [
                'name' => 'YP Nepal Administrator',
                'email' => 'globalconnection7@gmail.com',
                'password' => Hash::make('globalconnection@123!@#'),
                'is_active' => true,
            ]
        );
    }
}