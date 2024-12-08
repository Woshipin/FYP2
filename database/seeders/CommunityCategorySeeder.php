<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CommunityCategory;

class CommunityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Seeding CommunityCategorySeeder...\n";

        // 数据列表（包含类别名称及对应图标）
        $categories = [
            ['name' => 'transport', 'icon' => 'fa-bus'],
            ['name' => 'community', 'icon' => 'fa-users'],
            ['name' => 'social', 'icon' => 'fa-handshake'],
            ['name' => 'cultural', 'icon' => 'fa-palette'],
        ];

        // 循环插入数据
        foreach ($categories as $category) {
            CommunityCategory::create($category);
        }

        echo "CommunityCategorySeeder completed.\n";
    }
}
