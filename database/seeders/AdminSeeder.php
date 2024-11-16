<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '123456'
        ]);

        Admin::create([
            'name' => 'sj',
            'email' => 'sj@gmail.com',
            'password' => '123456'
        ]);

        Admin::create([
            'name' => 'abc',
            'email' => 'abc@gmail.com',
            'password' => '123456'
        ]);

        Admin::create([
            'name' => 'Pin',
            'email' => 'ahpin7762@gmail.com',
            'password' => '123456'
        ]);
    }
}
