<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StaffImport;
use App\Imports\ResortImport;
use App\Imports\HotelImport;
use App\Imports\RestaurantImport;
use App\Imports\RoomImport;
use App\Imports\TableImport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Imports\FacilityImport;

class ImportController extends Controller
{
    public function importStaff(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        Excel::import(new StaffImport, $request->file('file'));

        // Add your desired logic after importing the data

        return redirect()->back()->with('success', 'Staff imported successfully.');
    }

    public function importResort(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        // Get the authenticated user's ID
        $userId = auth()->user()->id;

        // Use the ResortImport class to import the Excel file and pass the user ID
        Excel::import(new ResortImport($userId), $request->file('file'));

        // Add your desired logic after importing the data

        return redirect()->back()->with('success', 'Resort imported successfully.');
    }

    public function importHotel(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        // Get the authenticated user's ID
        $userId = auth()->user()->id;

        // Use the HotelImport class to import the Excel file and pass the user ID
        Excel::import(new HotelImport($userId), $request->file('file'));

        // Add your desired logic after importing the data

        return redirect()->back()->with('success', 'Hotel imported successfully.');
    }

    public function importRestaurant(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        // Get the authenticated user's ID
        $userId = auth()->user()->id;

        // Use the RestaurantImport class to import the Excel file and pass the user ID
        Excel::import(new RestaurantImport($userId), $request->file('file'));

        // Add your desired logic after importing the data

        return redirect()->back()->with('success', 'Restaurant imported successfully.');
    }

    public function importRoom(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        // Get the authenticated user's ID
        $userId = auth()->user()->id;

        // Use the RoomImport class to import the Excel file and pass the user ID
        Excel::import(new RoomImport($userId), $request->file('file'));

        // Add your desired logic after importing the data

        return redirect()->back()->with('room', 'Room imported successfully.');
    }

    public function importTable(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        // Get the authenticated user's ID
        $userId = auth()->user()->id;

        // Use the TableImport class to import the Excel file and pass the user ID
        Excel::import(new TableImport($userId), $request->file('file'));

        // Add your desired logic after importing the data

        return redirect()->back()->with('table', 'Table imported successfully.');
    }

    public function importResortFacility(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new FacilityImport, $request->file('file'));

        return redirect()->back()->with('success', 'Facilities imported successfully!');
    }

}

