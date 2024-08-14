<?php

namespace App\Exports;

use App\Models\User;
use App\Models\BookingResort;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookedResortExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BookingResort::select('user_name','resort_name','gender','quantity','booking_date','checkin_time','checkout_time')->get();
    }

    public function headings(): array
    {
        return [
            'User_Name',
            'Resort_Name',
            'Gender',
            'Quantity',
            'Booking_date',
            'Check_in_Time',
            'Check_out_Time',
        ];
    }
}
