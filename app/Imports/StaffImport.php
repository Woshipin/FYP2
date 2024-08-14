<?php

namespace App\Imports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class StaffImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    // public function filter($row)
    // {
    //     // Check if you want to filter this row or not
    //     // For example, if the email already exists, skip this row
    //     return Staff::where('email', $row['email'])->count() == 0;
    // }

    public function model(array $row)
    {

        return new Staff([
            'name'      =>  $row['name'],
            'phone'      =>  $row['phone'],
            'salary'      =>  $row['salary'],
            'address'      =>  $row['address'],
        ]);
    }
}
