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
use Illuminate\Support\Facades\Mail;
use Session;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Mail\RejectionMail;

class AdminController extends Controller
{
    public function login()
    {
        // \Log::info('Accessing login page. Session status: ' . (Session()->has('loginId') ? 'Logged in' : 'Not logged in'));
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
            'email' => 'required|email',
            'password' => 'required|min:5|max:12'
        ]);

        $admin = Admin::where('email', '=', $request->email)->first();

        if($admin){
            // 检查密码是否匹配
            if(Hash::check($request->password, $admin->password)){
                $request->session()->put('loginId', $admin->id);
                $request->session()->put('loginName', $admin->name);
                return redirect('admin/dashboard');
            } else {
                return back()->with('fail', 'Password not matches.');
            }
        } else {
            return back()->with('fail', 'This email is not registered.');
        }
    }

    public function admindashboard(){

        if(!Session::has('loginId')){
            return redirect('admin/login');
        }

        $admin = Admin::find(Session::get('loginId'));
        if(!$admin){
            Session::forget('loginId');
            return redirect('admin/login')->with('fail', 'Admin not found. Please login again.');
        }

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
        ,'thisMonthbookedhotel','thisYearbookedhotel'))->with('success','Admin is Login Successfully!');
    }

    public function AdminWallet()
    {
        $adminwallets = AdminWallet::all();
        $totalBalance = AdminWallet::sum('balance');
        $totalTax = AdminWallet::sum('tax');
        $totalUserDeposit = AdminWallet::sum('user_deposit');

        return view('admin.AdminWallet', compact('adminwallets', 'totalBalance', 'totalTax', 'totalUserDeposit'));
    }

    // 'restaurantlabels', 'restaurantdata','resortlabels','resortdata',
    //     'hotellabels','hoteldata',

    public function logout(){
        if(Session::has('loginId')){
            Session::forget('loginId');  // 使用 forget 而不是 pull
            return redirect('admin/login')->with('fail', "You are Logout Successfully!");
        }
    }

    // public function logout(){
    //     Session::flush();
    //     return redirect('admin/login');
    // }

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

    //------------------------------------------------- Admin Control Resort Area -----------------------------------------------//
    public function showAllResort() {
        // Load resorts with images and paginate
        $resorts = Resort::with('images')->paginate(10);

        // Load all resorts with images without pagination (if needed elsewhere)
        $resortss = Resort::with('images')->get();

        return view('admin.AllResort', compact('resorts', 'resortss'));
    }

    public function updateResortRegisterStatus($id, Request $request) {
        $resort = Resort::find($id);
        if (!$resort) {
            return response()->json(['success' => false, 'message' => 'Resort not found']);
        }

        $resort->register_status = $request->status;
        $resort->save();

        return response()->json(['success' => true]);
    }

    public function rejectResort($id, Request $request)
    {
        try {
            \Log::info('Reject Resort Method Called', ['id' => $id, 'message' => $request->message]);

            $resort = Resort::find($id);
            if (!$resort) {
                return response()->json(['success' => false, 'message' => 'Resort not found']);
            }

            $resort->register_status = 2; // 标记为拒绝
            $resort->save();

            // 发送邮件通知
            $toEmail = 'ahpin7762@gmail.com'; // 确保这是正确的接收邮箱
            $messageContent = $request->message;

            Mail::to($toEmail)->send(new RejectionMail($messageContent));

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // 捕获并记录异常
            \Log::error('Reject Resort Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function AdminDeleteResort($id){

        Resort::where('id',$id)->delete();

        return back()->with('success','This Resort has been delete by Admin.');
    }

    public function AdminViewResort($id){

        $resorts = Resort::find($id);

        return view('admin.ViewAllResort',compact('resorts'));
    }

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

    //------------------------------------------------- Admin Control Restaurant Area -----------------------------------------------//
    public function showAllRestaurant(){

        $restaurants = Restaurant::with('images')->paginate(10);

        return view('admin.AllRestaurant',compact('restaurants'));
    }

    public function updateRestaurantRegisterStatus($id, Request $request)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return response()->json(['success' => false, 'message' => 'Restaurant not found']);
        }

        $restaurant->register_status = $request->status;
        $restaurant->save();

        return response()->json(['success' => true]);
    }

    public function rejectRestaurant($id, Request $request)
    {
        try {
            \Log::info('Reject Restaurant Method Called', ['id' => $id, 'message' => $request->message]);

            $restaurant = Restaurant::find($id);
            if (!$restaurant) {
                return response()->json(['success' => false, 'message' => 'Restaurant not found']);
            }

            $restaurant->register_status = 2; // 标记为拒绝
            $restaurant->save();

            // 发送邮件通知
            $toEmail = 'ahpin7762@gmail.com'; // 确保这是正确的接收邮箱
            $messageContent = $request->message;

            Mail::to($toEmail)->send(new RejectionMail($messageContent));

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // 捕获并记录异常
            \Log::error('Reject Restaurant Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
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

    //------------------------------------------------- Admin Control Hotel Area -----------------------------------------------//
    public function showAllHotel(){

        $hotels = Hotel::with('images')->paginate(10);

        return view('admin.AllHotel',compact('hotels'));
    }

    public function updateHotelRegisterStatus($id, Request $request) {

        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json(['success' => false, 'message' => 'Hotel not found']);
        }

        $hotel->register_status = $request->status;
        $hotel->save();

        return response()->json(['success' => true]);
    }

    public function rejectHotel($id, Request $request)
    {
        try {
            \Log::info('Reject Hotel Method Called', ['id' => $id, 'message' => $request->message]);

            $hotel = Hotel::find($id);
            if (!$hotel) {
                return response()->json(['success' => false, 'message' => 'Hotel not found']);
            }

            $hotel->register_status = 2; // 标记为拒绝
            $hotel->save();

            // 发送邮件通知
            $toEmail = 'ahpin7762@gmail.com'; // 确保这是正确的接收邮箱
            $messageContent = $request->message;

            Mail::to($toEmail)->send(new RejectionMail($messageContent));

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // 捕获并记录异常
            \Log::error('Reject Hotel Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function AdminViewHotel($id)
    {
        $hotels = Hotel::find($id);

        return view('admin.ViewAllHotel',compact('hotels'));
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
