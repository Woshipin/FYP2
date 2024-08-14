<?php

namespace App\Exports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StaffExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Staff::select('name','phone','salary','address')->get();
    }

    public function headings(): array
    {
        return [
            'Staff_Name',
            'Staff_Phone',
            'Staff_Salary',
            'Staff_Address',
        ];
    }
}
