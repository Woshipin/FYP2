<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Room;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RoomExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Room::select('name','type','available','price')->get();
    }

    public function headings(): array
    {
        return [
            'Room_Name',
            'Room_Type',
            'Room_Available',
            'Room_Price',
        ];
    }
}
