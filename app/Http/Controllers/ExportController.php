<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\StaffExport;
use App\Exports\ResortExport;
use App\Exports\HotelExport;
use App\Exports\RestaurantExport;
use App\Exports\RoomExport;
use App\Exports\TableExport;
use App\Exports\BookedResortExport;
use App\Exports\BookedRestaurantExport;
use App\Exports\BookedHotelExport;
use App\Exports\DepositExport;
use App\Exports\ContactExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportStaff()
    {
        return Excel::download(new StaffExport, 'Staff.xlsx');
    }

    public function exportResort()
    {
        return Excel::download(new ResortExport, 'Resort.xlsx');
    }

    public function exportHotel()
    {
        return Excel::download(new HotelExport, 'Hotel.xlsx');
    }

    public function exportRestaurant()
    {
        return Excel::download(new RestaurantExport, 'Restaurant.xlsx');
    }

    public function exportRoom()
    {
        return Excel::download(new RoomExport, 'Room.xlsx');
    }

    public function exportTable()
    {
        return Excel::download(new TableExport, 'Table.xlsx');
    }

    public function exportBookedResort()
    {
        return Excel::download(new BookedResortExport, 'BookedResort.xlsx');
    }

    public function exportBookedHotel()
    {
        return Excel::download(new BookedHotelExport, 'BookedHotel.xlsx');
    }

    public function exportBookedRestaurant()
    {
        return Excel::download(new BookedRestaurantExport, 'BookedRestaurant.xlsx');
    }

    public function exportDeposit()
    {
        return Excel::download(new DepositExport, 'Deposit.xlsx');
    }

    public function exportContact()
    {
        return Excel::download(new ContactExport, 'Contact.xlsx');
    }

    // public function exportSales()
    // {
    //     return Excel::download(new SalesExport, 'Sales.xlsx');
    // }

}
