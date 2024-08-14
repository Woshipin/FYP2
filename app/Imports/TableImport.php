<?php

namespace App\Imports;

use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TableImport implements ToModel, WithHeadingRow
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

        return new Table([
            'user_id'    => $userId,
            'restaurant_id'       => $row['restaurant_id'],
            'title'      => $row['title'],
        ]);
    }
}
