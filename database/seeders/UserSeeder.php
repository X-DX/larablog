<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\UserType;
use App\UserStatus;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'type' => UserType::SuperAdmin,
            'status' => UserStatus::Active,
        ]);
    }
}
