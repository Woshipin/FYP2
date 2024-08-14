<?php

namespace App\Exports;

use App\Models\User;
use App\Models\BookingRestaurant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookedRestaurantExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BookingRestaurant::select('user_name','restaurant_name','table_id','gender','quantity','booking_date','checkin_time','checkout_time')->get();
    }

    public function headings(): array
    {
        return [
            'User_Name',
            'Restaurant_Name',
            'Table_ID',
            'Gender',
            'Quantity',
            'Booking_date',
            'Check_in_Time',
            'Check_out_Time',
        ];
    }
}
