<?php

namespace App\Imports;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RestaurantImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            // $username = Auth::user()->name;
        } else {
            // 处理未认证用户的情况，可以抛出异常或采取其他措施
        }

        return new Restaurant([
            'user_id'    => $userId,
            'name'       => $row['name'],
            'image'      => $row['image'],
            'phone'      => $row['phone'],
            'email'      => $row['email'],
            'country'    => $row['country'],
            'type'    => $row['type'],
            'state'      => $row['state'],
            'date'       => $row['date'], // 直接赋值为 Excel 中的字符串
            'time'       => $row['time'], // 直接赋值为 Excel 中的字符串
            'address'   => $row['address'],
            'description' => $row['description'],
            'latitude'        => $row['latitude'],
            'longitude'        => $row['longitude'],
            'map'        => $row['map'],
        ]);

        dd($row['time']);
    }
}
