<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Resort;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResortExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Resort::select('name', 'price', 'phone', 'email', 'type', 'country', 'state', 'location', 'description', 'map')->get();
    }

    public function headings(): array
    {
        return [
            'Resort_Name',
            // 'Image',
            'Price',
            'Phone Number',
            'Email',
            'Type',
            'Country',
            'State',
            'Location',
            'Description',
            'Map',
        ];
    }
}
