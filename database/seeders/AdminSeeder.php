<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@umkmkauman.id'],
            [
                'name' => 'Admin Kauman',
                'phone' => '081234567890',
                'password' => 'password',
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}
