<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@givehope.com'],
            [
                'name' => 'System Admin',
                'username' => 'admin',
                'password' => Hash::make('admin123'), // Default password, user should change this
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
