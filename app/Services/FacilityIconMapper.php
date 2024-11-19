<?php

namespace App\Services;

class FacilityIconMapper
{
    protected static $iconMap = [
        'parking' => 'fa-square-parking',
        'restaurant' => 'fa-utensils',
        'pool' => 'fa-person-swimming',
        'wifi' => 'fa-wifi',
        'gym' => 'fa-dumbbell',
        'spa' => 'fa-spa',
        'bar' => 'fa-martini-glass',
        'laundry' => 'fa-shirt',
        'meeting' => 'fa-people-group',
        'airport' => 'fa-plane',
        'currency' => 'fa-money-bill-transfer',
        'luggage' => 'fa-suitcase',
        'percent' => 'fa-percent',
        'private parking' => 'fa-square-parking',
        'supporting area' => 'fa-handshake',
        'executive lounge' => 'fa-couch',
        'fitness room' => 'fa-dumbbell',
        'priority airport pick-up' => 'fa-plane-arrival',
        '5 restaurants' => 'fa-utensils',
        'cafe' => 'fa-mug-hot',
        'taxi booking service' => 'fa-taxi',
        'priority airport drop-off' => 'fa-plane-departure',
        'multi-function room' => 'fa-people-group',
        'business center' => 'fa-briefcase',
        'babysitting services' => 'fa-baby',
        '24-hour front desk' => 'fa-clock',
        'guest laundry' => 'fa-shirt',
    ];

    public static function getIcon(string $name): string
    {
        $name = strtolower($name);

        foreach (self::$iconMap as $key => $icon) {
            if (str_contains($name, $key)) {
                return $icon;
            }
        }

        return 'fa-circle-info'; // 默认图标
    }
}
