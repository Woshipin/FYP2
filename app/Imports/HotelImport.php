<?php

namespace App\Imports;

use App\Models\Hotel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HotelImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            // 处理未认证用户的情况，可以抛出异常或采取其他措施
        }

        return new Hotel([
            'user_id'    => $userId,
            'name'       => $row['name'],
            'type'      => $row['type'],
            'phone'      => $row['phone'],
            'email'      => $row['email'],
            'country'    => $row['country'],
            'state'      => $row['state'],
            'address'   => $row['address'],
            'description' => $row['description'],
            'latitude'        => $row['latitude'],
            'longitude'        => $row['longitude'],
            'digital_lock_password'        => $row['digital_lock_password'],
            'emailbox_password'        => $row['emailbox_password'],
            'map'        => $row['map'],
        ]);
    }
}
