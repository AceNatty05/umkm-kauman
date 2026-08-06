<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'user@umkmkauman.id'],
            [
                'name' => 'User Biasa',
                'phone' => '081234567891',
                'password' => 'password',
                'role' => 'user',
                'phone_verified' => true,
            ]
        );
    }
}
