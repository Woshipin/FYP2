<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserActivity;
use Illuminate\Support\Facades\DB;

class UserActivitySeeder extends Seeder
{
    public function run()
    {
        // 定义一些示例数据
        $activities = [
            ['user_id' => 1, 'entity_id' => 1, 'entity_type' => 'resort', 'activity_type' => 'view'],
            ['user_id' => 1, 'entity_id' => 2, 'entity_type' => 'hotel', 'activity_type' => 'like'],
            ['user_id' => 1, 'entity_id' => 1, 'entity_type' => 'resort', 'activity_type' => 'book'],
            ['user_id' => 1, 'entity_id' => 3, 'entity_type' => 'restaurant', 'activity_type' => 'view'],
            // 添加更多数据
        ];

        // 插入数据到 user_activities 表
        foreach ($activities as $activity) {
            UserActivity::create($activity);
        }
    }
}
