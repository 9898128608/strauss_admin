<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            [
                'first_name' => 'Adam',
                'last_name' => 'Allan',
                'mobile' => '1234567890',
                'email' => 'adam@strauss.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Strauss@08'),
                'role' => 'super-admin',
                'added_by' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Alexander',
                'last_name' => 'Anderson',
                'mobile' => '0987654321',
                'email' => 'alexander@strauss.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Strauss@08'),
                'role' => 'admin',
                'added_by' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Clark',
                'last_name' => 'Davidson',
                'mobile' => '0987654322',
                'email' => 'clark@strauss.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Strauss@08'),
                'role' => 'user',
                'added_by' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
