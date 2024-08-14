<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Restaurant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RestaurantExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Restaurant::select('name', 'image', 'phone', 'email', 'type', 'country', 'state', 'date', 'time', 'address', 'description', 'map')->get();
        // return collect([]);
    }

    public function headings(): array
    {
        return [
            'Restaurant_Name',
            'Image',
            'Phone',
            'Email',
            'Type',
            'Country',
            'State',
            'Date',
            'Time',
            'Address',
            'Description',
            'Map',
        ];
    }
}
