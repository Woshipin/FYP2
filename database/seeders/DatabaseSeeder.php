<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        // 调用其他 Seeder
        $this->call([
            GenderSeeder::class,
            AdminSeeder::class,
            // UserSeeder::class,
            FacilitySeeder::class,
            CommunityCategorySeeder::class,
        ]);
    }

}
