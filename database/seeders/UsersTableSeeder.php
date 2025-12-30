<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'brosis',
            'phone_number' => '1234567890',
            'email' => 'brosis@gmail.com',
            'password' => bcrypt('12345678'),
            'otp' => null,
            'status' => 'Active',
            'role' => 1,
        ]);
    }
}
