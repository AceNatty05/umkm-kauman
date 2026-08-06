<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Kauman',
            'phone' => '081234567890',
            'email' => 'admin@umkmkauman.id',
            'password' => 'password',
            'role' => 'admin',
            'phone_verified' => true,
        ]);
    }
}
