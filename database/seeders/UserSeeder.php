<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'User Biasa',
            'phone' => '081234567891',
            'email' => 'user@umkmkauman.id',
            'password' => 'password',
            'role' => 'user',
            'phone_verified' => true,
        ]);
    }
}
