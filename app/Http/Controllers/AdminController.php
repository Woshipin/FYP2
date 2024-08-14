<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingRestaurant;
use App\Models\BookingResort;
use App\Models\BookingHotel;
use App\Models\Admin;
use App\Models\Resort;
use App\Models\Hotel;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\Room;
use App\Models\User;
use App\Models\AdminWallet;
use Session;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function login(){

        return view('admin/login');
    }

    public function registration(){

        return view('admin/register');
    }

    public function registerAdmin(Request $request){

        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:admins',
            'password'=>'required|min:5|max:12'
        ]);

        $user = new Admin();
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->password = Hash::make($request->password);
        $user->password = $request->password;
        $res = $user->save();

        if($res){
            return back()->with('success', 'You have registered successfully');
        }else{
            return back()->with('fail', 'Something wrong');
        }
    }

    public function loginAdmin(Request $request){

        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12'
        ]);

        $admin = Admin::where('email', '=', $request->email)->first();

        if($admin){
            if(Hash::check($request->password, $admin->password)){
                $request->session()->put('loginId', $admin->id);
                $request->session()->put('loginName', $admin->name);
                return redirect('admin/dashboard');
            }else{
                return back()->with('fail','Password not matches.');
            }
        }else{
            return back()->with('fail','This email is not registered.');
        }
    }

    public function admindashboard(){

        $users = User::all();

        $data = array();
        if(Session::has('loginId')){
            $data = Admin::where('id', '=' , Session::get('loginId'))->first();
        }

        // Admin Resort Area Chart
        // $bookedresorts = BookingResort::selectRaw('COUNT(id) as total_bookings, DATE_FORMAT(booking_date, "%Y-%m-%d") as booking_month')
        //     ->groupBy('booking_month')
        //     ->orderBy('booking_month')
        //     ->get();

        // $resortlabels = [];
        // $resortdata = [];

        // foreach ($bookedresorts as $bookedresort) {
        //     // 使用日期格式 "YYYY-MM-dd" 作为标签
        //     $resortlabels[] = $bookedresort['booking_month'];
        //     $resortdata[] = $bookedresort['total_bookings'];
        // }

        // Admin Restaurant Area Chart
        // $bookedrestaurants = BookingRestaurant::selectRaw('COUNT(id) as total_bookings, DATE_FORMAT(booking_date, "%Y-%m-%d") as booking_month')
        //     ->groupBy('booking_month')
        //     ->orderBy('booking_month')
        //     ->get();

        // $restaurantlabels = [];
        // $restaurantdata = [];

        // foreach ($bookedrestaurants as $bookedrestaurant) {
        //     // 使用日期格式 "YYYY-MM-dd" 作为标签
        //     $restaurantlabels[] = $bookedrestaurant['booking_month'];
        //     $restaurantdata[] = $bookedrestaurant['total_bookings'];
        // }

        // Admin Hotel Area Chart
        // $bookedhotels = BookingHotel::selectRaw('COUNT(id) as total_bookings, DATE_FORMAT(booking_date, "%Y-%m-%d") as booking_month')
        //     ->groupBy('booking_month')
        //     ->orderBy('booking_month')
        //     ->get();

        // $hotellabels = [];
        // $hoteldata = [];

        // foreach ($bookedhotels as $bookedhotel) {
        //     // 使用日期格式 "YYYY-MM-dd" 作为标签
        //     $hotellabels[] = $bookedhotel['booking_month'];
        //     $hoteldata[] = $bookedhotel['total_bookings'];
        // }

        // All Booked Pie Chart
        // 收集已预订的餐厅、度假村和酒店的总预订数
        $bookedRestaurants = BookingRestaurant::count();
        $bookedResorts = BookingResort::count();
        $bookedHotels = BookingHotel::count();

        // 准备标签和数据数组
        $labels = ['Restaurants', 'Resorts', 'Hotels'];
        $data = [$bookedRestaurants, $bookedResorts, $bookedHotels];

        $todayDate = Carbon::now()->format('Y-m-d');
        $todayMonth = Carbon::now()->format('m');
        $todayYear = Carbon::now()->format('Y');

        // Restaurant Booked Count
        $totalbookedrestaurant = BookingRestaurant::count();
        $todaybookedrestaurant = BookingRestaurant::whereDate('created_at', $todayDate)->count();
        $thisMonthbookedrestaurant = BookingRestaurant::whereMonth('created_at', $todayMonth)->count();
        $thisYearbookedrestaurant = BookingRestaurant::whereYear('created_at', $todayYear)->count();

        // Resort Booked Count
        $totalbookedresort = BookingResort::count();
        $todaybookedresort = BookingResort::whereDate('created_at', $todayDate)->count();
        $thisMonthbookedresort = BookingResort::whereMonth('created_at', $todayMonth)->count();
        $thisYearbookedresort = BookingResort::whereYear('created_at', $todayYear)->count();

        // Hotel Booked Count
        $totalbookedhotel = BookingHotel::count();
        $todaybookedhotel = BookingHotel::whereDate('created_at', $todayDate)->count();
        $thisMonthbookedhotel = BookingHotel::whereMonth('created_at', $todayMonth)->count();
        $thisYearbookedhotel = BookingHotel::whereYear('created_at', $todayYear)->count();

        return view('admin/dashboard', compact('data','users','labels','data','totalbookedrestaurant','todaybookedrestaurant','thisMonthbookedrestaurant','thisYearbookedrestaurant',
        'totalbookedresort','todaybookedresort','thisMonthbookedresort','thisYearbookedresort','totalbookedhotel','todaybookedhotel'
        ,'thisMonthbookedhotel','thisYearbookedhotel'));
    }

    public function AdminWallet()
    {
        $adminwallets = AdminWallet::all();
        $totalBalance = AdminWallet::sum('balance');
        $totalTax = AdminWallet::sum('tax');
        $totalUserDeposit = AdminWallet::sum('user_deposit');

        return view('admin.AdminWallet', compact('adminwallets', 'totalBalance','totalTax','totalUserDeposit'));
    }

    // 'restaurantlabels', 'restaurantdata','resortlabels','resortdata',
    //     'hotellabels','hoteldata',

    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('admin/login');
        }
    }

    public function changeStatus($id){

        $getstatus = User::select('status')->where('id',$id)->first();

        if($getstatus->status==0){

            $status = 1;

        }else{

            $status = 0;
        }

        User::where('id',$id)->update(['status'=>$status]);

        return redirect()->back();
    }

    //Admin Control Resort Area
    public function showAllResort(){

        $resorts = Resort::paginate(10);
        $resortss = Resort::all();

        return view('admin.AllResort',compact('resorts','resortss'));
    }

    // public function AdminAddResort(Request $request){

    //     // |image|mimes:jpeg,png,jpg,gif|max:2048
    //     $request->validate([
    //         'name'=>'required',
    //         'image' =>'required',
    //         'price'=>'required',
    //         'location'=>'required',
    //         'latitude'=>'required',
    //         'longitude'=>'required',
    //         'description'=>'required'
    //     ]);

    //     // Handle image upload
    //     $image = $request->file('image');
    //     $image->move('images', $image->getClientOriginalName());
    //     $imageName = $image->getClientOriginalName();

    //     $resort = new Resort();
    //     $resort->user_id = auth()->id();
    //     $resort->name = $request->name;
    //     $resort->image = $imageName; // Corrected line
    //     $resort->price = $request->price;
    //     $resort->location = $request->location;
    //     $resort->latitude = $request->latitude;
    //     $resort->longitude = $request->longitude;
    //     $resort->description = $request->description;
    //     $resort->save();

    //     return back()->with('success', 'You have add new Resort successfully by Admin.');
    // }

    //View Resort with id
    // public function AdminShowResortMap($resortId)
    // {
    //     $resorts = Resort::find($resortId);

    //     return view('admin.ViewAllResort',compact('resorts'));
    // }

    //Mutliple Google Map
    // public function AdminShowAllResortMap()
    // {
    //     $resorts = Resort::all();

    //     return view('admin.AllResort', compact('resorts'));
    // }

    public function AdminEditResort($id){

        $resorts = Resort::find($id);

        return view('user.resort',compact('resorts'));
    }

    public function AdminUpdateResort(Request $request, $id){

        $resorts = Resort::find($id);

        // Handle image upload
        $image = $request->file('image');
        $image->move('images', $image->getClientOriginalName());
        $imageName = $image->getClientOriginalName();

        $resorts->name = $request->name;
        $resorts->image = $imageName; // Corrected line
        $resorts->price = $request->price;
        $resorts->location = $request->location;
        $resorts->latitude = $request->latitude;
        $resorts->longitude = $request->longitude;
        $resorts->description = $request->description;
        $resorts->save();

        return back()->with('success','This Resort has been updated successfully by Admin.');
    }

    public function AdminDeleteResort($id){

        Resort::where('id',$id)->delete();

        return back()->with('success','This Resort has been delete by Admin.');
    }

    public function AdminViewResort($id){

        $resorts = Resort::find($id);

        return view('admin.ViewAllResort',compact('resorts'));
    }

    // public function AdminSearchResort(Request $request)
    // {
    //     // Build your database query based on the input values
    //     $query = Resort::query();

    //     if ($request->has('name')) {
    //         $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
    //     }

    //     // Execute the query and retrieve the results
    //     // $resorts = $query->get();
    //     $resorts = $query->paginate(10);

    //     // Check if it's an AJAX request
    //     if ($request->ajax()) {
    //         return view('admin.AllResort', compact('resorts'));
    //     }

    //     // For non-AJAX requests, return the appropriate view
    //     return view('admin.AllResort', compact('resorts'));
    // }

    public function AdminSearchResort(Request $request)
    {
        // Build your database query based on the input values
        $query = Resort::query();

        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        // Execute the query and retrieve the results
        $resorts = $query->paginate(10);

        // Extract the items from the pagination data
        $resortsData = $resorts->items();

        // Check if it's an AJAX request
        if ($request->ajax()) {
            return view('admin.AllResort', compact('resorts', 'resortsData'));
        }

        // For non-AJAX requests, return the appropriate view
        return view('admin.AllResort', compact('resorts', 'resortsData'));
    }


    //Admin Control Restaurant Area
    public function showAllRestaurant(){

        $restaurants = Restaurant::paginate(10);

        return view('admin.AllRestaurant',compact('restaurants'));
    }

    public function AdminViewRestaurant($id)
    {
        $restaurants = Restaurant::find($id);

        return view('admin.ViewAllRestaurant',compact('restaurants'));
    }

    public function AdminEditRestaurant($id){

        $restaurant = Restaurant::find($id);

        return view('admin.AllRestaurant', compact('restaurant'));
    }

    public function AdminUpdateRestaurant(Request $request, $id){

        $restaurants = Restaurant::find($id);

        // Handle image upload
        $image = $request->file('image');
        $image->move('images', $image->getClientOriginalName());
        $imageName = $image->getClientOriginalName();

        $restaurants->name = $request->name;
        $restaurants->image = $imageName; // Corrected line
        $restaurants->date = $request->date;
        $restaurants->time = $request->time;
        $restaurants->address = $request->address;
        $restaurants->description = $request->description;
        $restaurants->map = $request->map;
        $restaurants->save();

        return back()->with('success','This Restaurant has been updated successfully by Admin.');
    }

    public function AdminDeleteRestaurant($id){

        Restaurant::where('id',$id)->delete();

        return back()->with('success','This Restaurant has been delete.');
    }

    public function AdminSearchRestaurant(Request $request)
    {
        // Build your database query based on the input values
        $query = Restaurant::query();

        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        // Execute the query and retrieve the results
        $restaurants = $query->paginate(10);

        // Extract the items from the pagination data
        $restaurantsData = $restaurants->items();

        // Check if it's an AJAX request
        if ($request->ajax()) {
            return view('admin.AllRestaurant', compact('restaurants', 'restaurantsData'));
        }

        // For non-AJAX requests, return the appropriate view
        return view('admin.AllRestaurant', compact('restaurants', 'restaurantsData'));
    }

    //Admin Control Hotel Area
    public function showAllHotel(){

        $hotels = Hotel::paginate(10);

        return view('admin.AllHotel',compact('hotels'));
    }

    public function AdminViewHotel($id)
    {
        $hotels = Hotel::find($id);

        return view('admin.ViewAllHotel',compact('hotels'));
    }

    public function AdminEditHotel($id){

        $hotels = Hotel::find($id);

        return view('admin.AllHotel', compact('hotels'));
    }

    public function AdminUpdateHotel(Request $request, $id){

        $hotels = Hotel::find($id);

        // Handle image upload
        $image = $request->file('image');
        $image->move('images', $image->getClientOriginalName());
        $imageName = $image->getClientOriginalName();

        $hotels->name = $request->name;
        $hotels->image = $imageName; // Corrected line
        $hotels->email = $request->email;
        $hotels->price = $request->price;
        $hotels->phone = $request->phone;
        $hotels->country = $request->country;
        $hotels->state = $request->state;
        $hotels->map = $request->map;
        $hotels->address = $request->address;
        $hotels->description = $request->description;
        $hotels->save();
        // dd($hotels);

        return back()->with('success','This Hotel has been updated successfully by Admin.');
    }

    public function AdminDeleteHotel($id){

        Hotel::where('id',$id)->delete();

        return back()->with('success','This Hotel has been delete.');
    }

    public function AdminSearchHotel(Request $request)
    {
        // Build your database query based on the input values
        $query = Hotel::query();

        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        // Execute the query and retrieve the results
        // $hotels = $query->get();
        $hotels = $query->paginate(10);

        // dd($hotels);

        // Check if it's an AJAX request
        if ($request->ajax()) {
            return view('admin.AllHotel', compact('hotels'));
        }

        // For non-AJAX requests, return the appropriate view
        return view('admin.AllHotel', compact('hotels'));
    }


    //Admin Control Table Area
    public function showAllTable(){

        $tables = Table::paginate(10);
        $restaurantd = Restaurant::all();

        return view('admin.AllTable',compact('restaurantd','tables'));
    }

    public function AdminEditTable($id){

        $tables = Table::find($id);
        $restaurantd = Restaurant::all();

        return view('admin.AllTable',compact('restaurantd','tables'));
    }

    public function AdminUpdateTable(Request $request, $id){

        $tables = Table::find($id);

        $tables->restaurant_id = $request->restaurant_id;
        $tables->title = $request->title;
        $tables->save();

        return back()->with('success','This Table has been updated successfully by Admin.');
    }

    public function AdminDeleteTable($id){

        Table::where('id',$id)->delete();

        return back()->with('success','This Table has been delete.');
    }

    //Admin Control Room Area
    public function showAllRoom(){

        $rooms = Room::paginate(10);
        $hoteld = Hotel::all();

        return view('admin.AllRoom',compact('hoteld','rooms'));
    }

    public function AdminEditRoom($id){

        $rooms = Room::find($id);
        $hoteld = Hotel::all();

        return view('admin.AllRoom',compact('hoteld','rooms'));
    }

    public function AdminUpdateRoom(Request $request, $id){

        $rooms = Room::find($id);

        $rooms->hotel_id = $request->hotel_id;
        $rooms->name = $request->name;
        $rooms->save();

        return back()->with('success','This Room has been updated successfully by Admin.');
    }

    public function AdminDeleteRoom($id){

        Room::where('id',$id)->delete();

        return back()->with('success','This Room has been delete.');
    }
}
