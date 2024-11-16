<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        echo "Seeding UserSeeder...\n";

        User::create([
            'name' => 'abc',
            'email' => 'abc@gmail.com',
            'password' => '123456', // Use plain password here
            'status' => 0
        ]);

        User::create([
            'name' => 'Pin',
            'email' => 'ahpin7762@gmail.com',
            'password' => '123456', // Use plain password here
            'status' => 0
        ]);

        User::create([
            'name' => 'sj',
            'email' => 'sj@gmail.com',
            'password' => '123456',
            'status' => 0
        ]);

        User::create([
            'name' => 'jeremy',
            'email' => 'jeremy@gmail.com',
            'password' => '123456',
            'status' => 0
        ]);

        echo "UserSeeder completed.\n";
    }
}
