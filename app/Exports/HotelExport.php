<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Hotel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HotelExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Hotel::select('name', 'image', 'phone', 'email', 'type', 'country', 'state', 'address', 'map','description')->get();
    }

    public function headings(): array
    {
        return [
            'Hotel_Name',
            'Image',
            'Phone Number',
            'Email',
            'Type',
            'Country',
            'State',
            'Address',
            'Map',
            'Description',
        ];
    }
}
