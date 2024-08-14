<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\BookingRestaurant;
use App\Models\BookingResort;
use App\Models\BookingHotel;
use App\Models\User;
use App\Models\Contact;
use App\Models\Restaurant;
use App\Models\Resort;
use App\Models\Hotel;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use PDF;

class PDFController extends Controller
{
    // Staff PDF Function
    public function viewStaffPDF(){

        $staffs = Staff::all();

        // view landscape PDF
        $pdf = PDF::loadView('pdf.viewstaffpdf',compact('staffs'))
        ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function downloadStaffPDF(){

        $staffs = Staff::all();

        // view landscape PDF
        $pdf = PDF::loadView('pdf.viewstaffpdf',compact('staffs'))
        ->setPaper('a4', 'landscape');

        //file name
        return $pdf->download('staff-details.pdf');
    }

    public function viewBookedHotelPDF()
    {
        $user = auth()->user();

        $hotelIds = $user->hotels()->pluck('id')->toArray();

        // Get the query builder instance before fetching results
        $hasBookedQuery = BookingHotel::whereIn('hotel_id', $hotelIds);

        // Paginate the query builder instance
        $hotels = $hasBookedQuery->get();

        // dd($hotels);

        $pdf = PDF::loadView('pdf.viewbookedhotelpdf', compact('hotels'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream(); // To display the PDF in the browser
    }

    public function downloadBookedHotelDetailPdf($bookingId)
    {
        // Retrieve booked hotel information based on $bookingId
        $bookedhotels = BookingHotel::with(['hotel', 'room', 'user'])->find($bookingId);

        // Generate PDF using the booked hotel information and the PDF view
        $pdf = PDF::loadView('pdf.bookedhoteldetail', compact('bookedhotels'));

        // Display the live PDF view
        return $pdf->stream();

        // Download the PDF file
        // return $pdf->download('booked_hotel_invoice.pdf');
    }

    public function downloadBookedHotelPDF()
    {
        $user = auth()->user(); // Retrieve the authenticated user
        $userId = $user->id;

        $hotels = BookingHotel::where('user_id', $userId)->get();

        $pdf = PDF::loadView('pdf.viewbookedhotelpdf', compact('hotels'))
            ->setPaper('a4', 'landscape');

        // File name
        return $pdf->download('BookedHotel-details.pdf');
    }

    public function viewresortPDF()
    {
        $user = auth()->user();

        $resortIds = $user->resorts()->pluck('id')->toArray();

        // Get the query builder instance before fetching results
        $hasBookedQuery = BookingResort::whereIn('resort_id', $resortIds);

        // Paginate the query builder instance
        $resorts = $hasBookedQuery->get();

        // dd($resortIds);
        // dd($resorts);

        $pdf = PDF::loadView('pdf.viewbookedresortpdf', compact('resorts'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream(); // To display the PDF in the browser
    }

    public function downloadBookedResortDetailPdf($bookingId)
    {
        // Retrieve booked hotel information based on $bookingId
        $bookedresorts = BookingResort::with(['resort','user'])->find($bookingId);

        // Generate PDF using the booked hotel information and the PDF view
        $pdf = PDF::loadView('pdf.bookedresortdetail', compact('bookedresorts'));

        // Display the live PDF view
        return $pdf->stream();

        // Download the PDF file
        // return $pdf->download('booked_hotel_invoice.pdf');
    }

    public function downloadBookedResortPDF(){

        $user = auth()->user(); // Retrieve the authenticated user
        $userId = $user->id;

        $resorts = BookingResort::where('user_id', $userId)->get();

        $pdf = PDF::loadView('pdf.viewbookedresortpdf', compact('resorts'))
            ->setPaper('a4', 'landscape');

        // File name
        return $pdf->download('BookedResort-details.pdf');
    }

    // public function downloadBookedResortPDF()
    // {
    //     $user = auth()->user();
    //     $userId = $user->id;

    //     $resorts = BookingResort::where('user_id', $userId)->get();

    //     $pdf = PDF::loadView('pdf.viewbookedresortpdf', compact('resorts'))
    //         ->setPaper('a4', 'landscape');

    //     // Define the file name for the downloaded PDF
    //     $fileName = 'BookedResort-details.pdf';

    //     // Set the content type and headers for download
    //     return $pdf->download($fileName);
    // }

    public function downloadBookedRestaurantDetailPdf($bookingId)
    {
        // Retrieve booked hotel information based on $bookingId
        $bookedrestaurants = BookingRestaurant::with(['restaurant', 'table', 'user'])->find($bookingId);

        // Generate PDF using the booked hotel information and the PDF view
        $pdf = PDF::loadView('pdf.bookedrestaurantdetail', compact('bookedrestaurants'));

        // Display the live PDF view
        return $pdf->stream();

        // Download the PDF file
        // return $pdf->download('booked_hotel_invoice.pdf');
    }

    public function viewrestaurantPDF()
    {
        $user = auth()->user();

        $restaurantIds = $user->restaurants()->pluck('id')->toArray();

        // Get the query builder instance before fetching results
        $hasBookedQuery = BookingRestaurant::whereIn('restaurant_id', $restaurantIds);

        // Paginate the query builder instance
        $restaurants = $hasBookedQuery->get();

        $pdf = PDF::loadView('pdf.viewbookedrestaurantpdf', compact('restaurants'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream(); // To display the PDF in the browser
    }

    public function downloadBookedRestaurantPDF(){

        $user = auth()->user(); // Retrieve the authenticated user
        $userId = $user->id;

        $restaurants = BookingRestaurant::where('user_id', $userId)->get();

        // dd($restaurants);

        $pdf = PDF::loadView('pdf.viewbookedrestaurantpdf', compact('restaurants'))
            ->setPaper('a4', 'landscape');

        //file name
        return $pdf->download('BookedRestaurant-details.pdf');
    }

    public function viewdashboardPDF(){

        // set_time_limit(180);

        // User Restaurant Area Chart
        $userId = auth()->id(); // Get the authenticated user's ID

        $bookedrestaurants = BookingRestaurant::selectRaw('COUNT(id) as total_bookings, DATE_FORMAT(booking_date, "%Y-%m-%d") as booking_month')
            ->where('user_id', $userId) // Filter by user ID
            ->groupBy('booking_month')
            ->orderBy('booking_month')
            ->get();

        $restaurantlabels = [];
        $restaurantdata = [];

        foreach ($bookedrestaurants as $bookedrestaurant) {
            // Use the date format "YYYY-MM-dd" as labels
            $restaurantlabels[] = $bookedrestaurant['booking_month'];
            $restaurantdata[] = $bookedrestaurant['total_bookings'];
        }

        // User Resort Area Chart
        $userId = auth()->id(); // Get the authenticated user's ID

        $bookedresorts = BookingResort::selectRaw('COUNT(id) as total_bookings, DATE_FORMAT(booking_date, "%Y-%m-%d") as booking_month')
            ->where('user_id', $userId) // Filter by user ID
            ->groupBy('booking_month')
            ->orderBy('booking_month')
            ->get();

        $resortlabels = [];
        $resortdata = [];

        foreach ($bookedresorts as $bookedresort) {
            // Use the date format "YYYY-MM-dd" as labels
            $resortlabels[] = $bookedresort['booking_month'];
            $resortdata[] = $bookedresort['total_bookings'];
        }

        // User Hotel Area Chart
        $userId = auth()->id(); // Get the authenticated user's ID

        $bookedhotels = BookingHotel::selectRaw('COUNT(id) as total_bookings, DATE_FORMAT(booking_date, "%Y-%m-%d") as booking_month')
            ->where('user_id', $userId) // Filter by user ID
            ->groupBy('booking_month')
            ->orderBy('booking_month')
            ->get();

        $hotellabels = [];
        $hoteldata = [];

        foreach ($bookedhotels as $bookedhotel) {
            // Use the date format "YYYY-MM-dd" as labels
            $hotellabels[] = $bookedhotel['booking_month'];
            $hoteldata[] = $bookedhotel['total_bookings'];
        }

        // All Booked Pie Chart
        // 收集已预订的餐厅、度假村和酒店的总预订数
        // Get the authenticated user's ID
        $userId = auth()->id();

        // Collect the total bookings for restaurants, resorts, and hotels for the authenticated user
        $bookedRestaurants = BookingRestaurant::where('user_id', $userId)->count();
        $bookedResorts = BookingResort::where('user_id', $userId)->count();
        $bookedHotels = BookingHotel::where('user_id', $userId)->count();

        // Prepare labels and data arrays
        $labels = ['Restaurants', 'Resorts', 'Hotels'];
        $data = [$bookedRestaurants, $bookedResorts, $bookedHotels];


        // Get Booked Restaurant with auth id
        $todayDate = Carbon::now()->format('Y-m-d');
        $todayMonth = Carbon::now()->format('m');
        $todayYear = Carbon::now()->format('Y');

        // All Restaurant Resort and Hotel count with auth id
        $bookedRestaurant = Restaurant::where('user_id', $userId)->count();
        $bookedResort = Resort::where('user_id', $userId)->count();
        $bookedHotel = Hotel::where('user_id', $userId)->count();

        // Resort bookings for today for the user
        $todaybookedresort = BookingResort::where('user_id', $userId)
            ->whereDate('created_at', $todayDate)
            ->count();

        // Resort bookings for the current month for the user
        $thisMonthbookedresort = BookingResort::where('user_id', $userId)
            ->whereMonth('created_at', $todayMonth)
            ->count();

        // Resort bookings for the current year for the user
        $thisYearbookedresort = BookingResort::where('user_id', $userId)
            ->whereYear('created_at', $todayYear)
            ->count();

        // Restaurant bookings for today for the user
        $todaybookedrestaurant = BookingRestaurant::where('user_id', $userId)
            ->whereDate('created_at', $todayDate)
            ->count();

        // Restaurant bookings for the current month for the user
        $thisMonthbookedrestaurant = BookingRestaurant::where('user_id', $userId)
            ->whereMonth('created_at', $todayMonth)
            ->count();

        // Restaurant bookings for the current year for the user
        $thisYearbookedrestaurant = BookingRestaurant::where('user_id', $userId)
            ->whereYear('created_at', $todayYear)
            ->count();

        // Hotel bookings for today for the user
        $todaybookedhotel = BookingHotel::where('user_id', $userId)
            ->whereDate('created_at', $todayDate)
            ->count();

        // Hotel bookings for the current month for the user
        $thisMonthbookedhotel = BookingHotel::where('user_id', $userId)
            ->whereMonth('created_at', $todayMonth)
            ->count();

        // Hotel bookings for the current year for the user
        $thisYearbookedhotel = BookingHotel::where('user_id', $userId)
            ->whereYear('created_at', $todayYear)
            ->count();

        // view landscape PDF
        $pdf = PDF::loadView('pdf.viewdashboardpdf',compact('restaurantlabels', 'restaurantdata','restaurantlabels', 'restaurantdata','resortlabels','resortdata','hotellabels','hoteldata','labels','data',
        'bookedRestaurants','bookedResorts','bookedHotels','todaybookedrestaurant','thisMonthbookedrestaurant','thisYearbookedrestaurant',
        'todaybookedresort','thisMonthbookedresort','thisYearbookedresort','todaybookedhotel','thisMonthbookedhotel','thisYearbookedhotel',
        'bookedRestaurant','bookedResort','bookedHotel'));

        return $pdf->stream();
    }

    public function downloaddashboardPDF(){

        // User Restaurant Area Chart
        $userId = auth()->id(); // Get the authenticated user's ID

        $bookedrestaurants = BookingRestaurant::selectRaw('COUNT(id) as total_bookings, DATE_FORMAT(booking_date, "%Y-%m-%d") as booking_month')
            ->where('user_id', $userId) // Filter by user ID
            ->groupBy('booking_month')
            ->orderBy('booking_month')
            ->get();

        $restaurantlabels = [];
        $restaurantdata = [];

        foreach ($bookedrestaurants as $bookedrestaurant) {
            // Use the date format "YYYY-MM-dd" as labels
            $restaurantlabels[] = $bookedrestaurant['booking_month'];
            $restaurantdata[] = $bookedrestaurant['total_bookings'];
        }

        // User Resort Area Chart
        $userId = auth()->id(); // Get the authenticated user's ID

        $bookedresorts = BookingResort::selectRaw('COUNT(id) as total_bookings, DATE_FORMAT(booking_date, "%Y-%m-%d") as booking_month')
            ->where('user_id', $userId) // Filter by user ID
            ->groupBy('booking_month')
            ->orderBy('booking_month')
            ->get();

        $resortlabels = [];
        $resortdata = [];

        foreach ($bookedresorts as $bookedresort) {
            // Use the date format "YYYY-MM-dd" as labels
            $resortlabels[] = $bookedresort['booking_month'];
            $resortdata[] = $bookedresort['total_bookings'];
        }

        // User Hotel Area Chart
        $userId = auth()->id(); // Get the authenticated user's ID

        $bookedhotels = BookingHotel::selectRaw('COUNT(id) as total_bookings, DATE_FORMAT(booking_date, "%Y-%m-%d") as booking_month')
            ->where('user_id', $userId) // Filter by user ID
            ->groupBy('booking_month')
            ->orderBy('booking_month')
            ->get();

        $hotellabels = [];
        $hoteldata = [];

        foreach ($bookedhotels as $bookedhotel) {
            // Use the date format "YYYY-MM-dd" as labels
            $hotellabels[] = $bookedhotel['booking_month'];
            $hoteldata[] = $bookedhotel['total_bookings'];
        }

        // All Booked Pie Chart
        // 收集已预订的餐厅、度假村和酒店的总预订数
        // Get the authenticated user's ID
        $userId = auth()->id();

        // Collect the total bookings for restaurants, resorts, and hotels for the authenticated user
        $bookedRestaurants = BookingRestaurant::where('user_id', $userId)->count();
        $bookedResorts = BookingResort::where('user_id', $userId)->count();
        $bookedHotels = BookingHotel::where('user_id', $userId)->count();

        // Prepare labels and data arrays
        $labels = ['Restaurants', 'Resorts', 'Hotels'];
        $data = [$bookedRestaurants, $bookedResorts, $bookedHotels];


        // Get Booked Restaurant with auth id
        $todayDate = Carbon::now()->format('Y-m-d');
        $todayMonth = Carbon::now()->format('m');
        $todayYear = Carbon::now()->format('Y');

        // All Restaurant Resort and Hotel count with auth id
        $bookedRestaurant = Restaurant::where('user_id', $userId)->count();
        $bookedResort = Resort::where('user_id', $userId)->count();
        $bookedHotel = Hotel::where('user_id', $userId)->count();

        // Resort bookings for today for the user
        $todaybookedresort = BookingResort::where('user_id', $userId)
            ->whereDate('created_at', $todayDate)
            ->count();

        // Resort bookings for the current month for the user
        $thisMonthbookedresort = BookingResort::where('user_id', $userId)
            ->whereMonth('created_at', $todayMonth)
            ->count();

        // Resort bookings for the current year for the user
        $thisYearbookedresort = BookingResort::where('user_id', $userId)
            ->whereYear('created_at', $todayYear)
            ->count();

        // Restaurant bookings for today for the user
        $todaybookedrestaurant = BookingRestaurant::where('user_id', $userId)
            ->whereDate('created_at', $todayDate)
            ->count();

        // Restaurant bookings for the current month for the user
        $thisMonthbookedrestaurant = BookingRestaurant::where('user_id', $userId)
            ->whereMonth('created_at', $todayMonth)
            ->count();

        // Restaurant bookings for the current year for the user
        $thisYearbookedrestaurant = BookingRestaurant::where('user_id', $userId)
            ->whereYear('created_at', $todayYear)
            ->count();

        // Hotel bookings for today for the user
        $todaybookedhotel = BookingHotel::where('user_id', $userId)
            ->whereDate('created_at', $todayDate)
            ->count();

        // Hotel bookings for the current month for the user
        $thisMonthbookedhotel = BookingHotel::where('user_id', $userId)
            ->whereMonth('created_at', $todayMonth)
            ->count();

        // Hotel bookings for the current year for the user
        $thisYearbookedhotel = BookingHotel::where('user_id', $userId)
            ->whereYear('created_at', $todayYear)
            ->count();

        // view landscape PDF
        $pdf = PDF::loadView('pdf.viewdashboardpdf',compact('restaurantlabels', 'restaurantdata','restaurantlabels', 'restaurantdata','resortlabels','resortdata','hotellabels','hoteldata','labels','data',
        'bookedRestaurants','bookedResorts','bookedHotels','todaybookedrestaurant','thisMonthbookedrestaurant','thisYearbookedrestaurant',
        'todaybookedresort','thisMonthbookedresort','thisYearbookedresort','todaybookedhotel','thisMonthbookedhotel','thisYearbookedhotel',
        'bookedRestaurant','bookedResort','bookedHotel'));

        //file name
        return $pdf->download('dashboard.pdf');
    }


    // Resort PDF Function
    // public function viewResortPDF(){

    //     $resorts = Resort::all();

    //     // view landscape PDF
    //     $pdf = PDF::loadView('pdf.viewresortpdf',compact('resorts'))
    //     ->setPaper('a4','portrait');

    //     return $pdf->stream();
    // }

    // public function downloadResortPDF(){

    //     $resorts = Resort::all();

    //     // view landscape PDF
    //     $pdf = PDF::loadView('pdf.viewresortpdf',compact('resorts'))
    //     ->setPaper('a4','portrait');

    //     //file name
    //     return $pdf->download('resort-details.pdf');
    // }
}
