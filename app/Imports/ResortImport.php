<?php

namespace App\Imports;

use App\Models\Resort;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResortImport implements ToModel, WithHeadingRow
{

    // protected $userId;

    // public function __construct($userId)
    // {
    //     $this->userId = $userId;
    // }

    public function model(array $row)
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            // 处理未认证用户的情况，可以抛出异常或采取其他措施
        }

        return new Resort([
            'user_id'    => $userId,
            'name'       => $row['name'],
            'price'      => $row['price'],
            'type'      => $row['type'],
            'phone'      => $row['phone'],
            'email'      => $row['email'],
            'country'    => $row['country'],
            'state'      => $row['state'],
            'location'   => $row['location'],
            'description' => $row['description'],
            'latitude'        => $row['latitude'],
            'longitude'        => $row['longitude'],
            'digital_lock_password'        => $row['digital_lock_password'],
            'emailbox_password'        => $row['emailbox_password'],
            'map'        => $row['map'],
        ]);
    }

}
