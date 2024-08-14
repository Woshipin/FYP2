<?php

namespace App\Imports;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RoomImport implements ToModel, WithHeadingRow
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

        return new Room([
            'user_id'    => $userId,
            'hotel_id'       => $row['hotel_id'],
            'name'      => $row['name'],
            'type'      => $row['type'],
            'available'      => $row['available'],
            'price'      => $row['price'],
        ]);
    }
}
