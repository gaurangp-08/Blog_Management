<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'admin', 'email' => 'admin@example.com', 'password' => 'abcd@123'],
            ['name' => 'John Miller', 'email' => 'john.miller@example.com', 'password' => 'xyz@123'],
            ['name' => 'Emma Johnson', 'email' => 'emma.johnson@example.com', 'password' => 'abc@123'],
            ['name' => 'William Brown', 'email' => 'william.brown@example.com', 'password' => 'will@123'],
            ['name' => 'Olivia Davis', 'email' => 'olivia.davis@example.com', 'password' => 'olivia@123'],
            ['name' => 'James Wilson', 'email' => 'james.wilson@example.com', 'password' => 'james@123'],
            ['name' => 'Sophia Taylor', 'email' => 'sophia.taylor@example.com', 'password' => 'sophia@123'],
            ['name' => 'Michael Anderson', 'email' => 'michael.anderson@example.com', 'password' => 'mike@123'],
            ['name' => 'Isabella Thomas', 'email' => 'isabella.thomas@example.com', 'password' => 'bella@123'],
            ['name' => 'Daniel Martinez', 'email' => 'daniel.martinez@example.com', 'password' => 'daniel@123'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                ]
            );
        }
    }
}
