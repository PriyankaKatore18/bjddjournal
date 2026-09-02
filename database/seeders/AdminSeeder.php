<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; // Use your Admin model

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::updateOrCreate(
            ['email' => 'admin@example.com'], // Email to check if exists
            [
                'name' => 'Super Admin',
                'password' => 'admin123', // Plain text password
            ]
        );
    }
}
