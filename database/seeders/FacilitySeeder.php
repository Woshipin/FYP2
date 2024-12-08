<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;
use App\Services\FacilityIconMapper;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Seeding FacilitySeeder...\n";

        // 定义初始设施数据
        $facilities = [
            ['name' => 'Parking', 'charge_type' => 'free', 'display_order' => 1, 'icon' => 'fa-square-parking'],
            ['name' => 'Restaurant', 'charge_type' => 'additional_charge', 'display_order' => 2, 'icon' => 'fa-utensils'],
            ['name' => 'Swimming Pool', 'charge_type' => 'free', 'display_order' => 3, 'icon' => 'fa-person-swimming'],
            ['name' => 'WiFi', 'charge_type' => 'free', 'display_order' => 4, 'icon' => 'fa-wifi'],
            ['name' => 'Gym', 'charge_type' => 'none', 'display_order' => 5, 'icon' => 'fa-dumbbell'],
            ['name' => 'Spa', 'charge_type' => 'additional_charge', 'display_order' => 6, 'icon' => 'fa-spa'],
            ['name' => 'Bar', 'charge_type' => 'additional_charge', 'display_order' => 7, 'icon' => 'fa-martini-glass'],
            ['name' => 'Laundry Service', 'charge_type' => 'additional_charge', 'display_order' => 8, 'icon' => 'fa-shirt'],
            ['name' => 'Meeting Room', 'charge_type' => 'none', 'display_order' => 9, 'icon' => 'fa-people-group'],
            ['name' => 'Airport Transfer', 'charge_type' => 'additional_charge', 'display_order' => 10, 'icon' => 'fa-plane'],
            ['name' => 'Currency Exchange', 'charge_type' => 'none', 'display_order' => 11, 'icon' => 'fa-money-bill-transfer'],
            ['name' => 'Luggage Storage', 'charge_type' => 'none', 'display_order' => 12, 'icon' => 'fa-suitcase'],
            ['name' => 'Priority Airport Pick-up', 'charge_type' => 'additional_charge', 'display_order' => 13, 'icon' => 'fa-plane-arrival'],
            ['name' => '5 Restaurants', 'charge_type' => 'additional_charge', 'display_order' => 14, 'icon' => 'fa-utensils'],
            ['name' => 'Cafe', 'charge_type' => 'additional_charge', 'display_order' => 15, 'icon' => 'fa-mug-hot'],
            ['name' => 'Taxi Booking Service', 'charge_type' => 'additional_charge', 'display_order' => 16, 'icon' => 'fa-taxi'],
            ['name' => 'Priority Airport Drop-off', 'charge_type' => 'additional_charge', 'display_order' => 17, 'icon' => 'fa-plane-departure'],
            ['name' => 'Multi-function Room', 'charge_type' => 'none', 'display_order' => 18, 'icon' => 'fa-people-group'],
            ['name' => 'Business Center', 'charge_type' => 'none', 'display_order' => 19, 'icon' => 'fa-briefcase'],
            ['name' => 'Babysitting Services', 'charge_type' => 'additional_charge', 'display_order' => 20, 'icon' => 'fa-baby'],
            ['name' => '24-hour Front Desk', 'charge_type' => 'none', 'display_order' => 21, 'icon' => 'fa-clock'],
            ['name' => 'Guest Laundry', 'charge_type' => 'additional_charge', 'display_order' => 22, 'icon' => 'fa-shirt'],
        ];

        // 更新 FacilitySeeder
        foreach ($facilities as $facility) {
            Facility::create([
                'name' => $facility['name'],
                'charge_type' => $facility['charge_type'],
                'display_order' => $facility['display_order'],
                // 不再插入 'icon'，因为它是动态生成的
            ]);
        }

        echo "FacilitySeeder completed.\n";
    }
}
