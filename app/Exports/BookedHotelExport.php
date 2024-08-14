<?php

namespace App\Exports;

use App\Models\User;
use App\Models\BookingHotel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookedHotelExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BookingHotel::select('user_name','hotel_name','room_id','gender','quantity','booking_date','checkin_time','checkout_time')->get();
    }

    public function headings(): array
    {
        return [
            'User_Name',
            'Hotel_Name',
            'Room_id',
            'Gender',
            'Quantity',
            'Booking_date',
            'Check_in_Time',
            'Check_out_Time',
        ];
    }
}
