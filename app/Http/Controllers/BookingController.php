<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Restaurant;
use App\Models\Resort;
use App\Models\Hotel;
use App\Models\Deposit;
use App\Models\BookingRestaurant;
use App\Models\BookingResort;
use App\Models\BookingHotel;
use App\Models\Table;
use App\Models\Room;
use App\Models\Gender;
use App\Models\User;
use App\Models\AdminWallet;
use App\Models\MyWallet;
use Auth;
use Mail;
use Carbon\Carbon;
use App\Events\BookingStatus;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Mail\ResortPaymentVerification;
use App\Mail\HotelPaymentVerification;
use App\Mail\RestaurantPaymentVerification;

class BookingController extends Controller
{

    //----------------------------------------------------Frontend Booking Restaurant Area --------------------------------------------//

    // Jian An Full Code
    // public function bookingpage(Request $request, $id)
    // {
    //     if(Auth::check()){

    //         $tables = Table::where('restaurant_id', $id)->pluck('id');
    //         $bookedData = BookingRestaurant::where('restaurant_id', $id)
    //             ->get()
    //             ->groupBy('booking_date')
    //             ->map(function ($bookings) {
    //                 return $bookings->pluck('table_id')->toArray();
    //             });

    //         $booked = $bookedData->toArray();
    //         $results = Table::where('restaurant_id',$id)->pluck('id', 'title');
    //         $genders = Gender::all();
    //         $restaurants = Restaurant::find($id);

    //         // 设置 $booking_date 变量，例如：
    //         $booking_date = date('Y-m-d'); // 以当前日期为例

    //         $restaurant_price = $request->restaurant_price;
    //         $deposit_price = $restaurant_price * 0.1;

    //         // $tablesJson = json_encode($tables);
    //         // $bookedJson = json_encode($booked);
    //         // $resultsJson = json_encode($results);

    //         // event(new BookingStatus());

    //     }else{

    //         return redirect()->route('frontend-auth.login')->with('error', 'You need to log in first.');
    //     }
    //         return view('frontend-auth.frontend-restaurant.bookingrestaurant', compact('tables', 'restaurants', 'booked', 'results','genders','booking_date','deposit_price'));
    // }

    // Special Full Code
    public function bookingpage(Request $request, $id)
    {
        if (Auth::check()) {
            $tables = Table::where('restaurant_id', $id)
                ->where('status', 0)
                ->get();

            $genders = Gender::all();
            $restaurants = Restaurant::find($id);

            $bookings = $this->getRestaurantBookings($id); // Retrieve booking details

        } else {
            return redirect()->route('frontend-auth.login')->with('error', 'You need to log in first.');
        }

        return view('frontend-auth.special.bookingrestaurant', compact('tables', 'restaurants', 'genders', 'bookings'));
    }

    public function getRestaurantBookings($restaurantId)
    {
        // Retrieve bookings for the specified restaurant
        $bookings = BookingRestaurant::where('restaurant_id', $restaurantId)
                    ->select('booking_date', 'checkin_time', 'checkout_time', 'table_id')
                    ->get();

        $bookingDetails = [];

        // Format the booking details as needed
        foreach ($bookings as $booking) {
            $bookingDetails[] = [
                'booking_date' => Carbon::parse($booking->booking_date)->format('Y-m-d'),
                'checkin_time' => Carbon::parse($booking->checkin_time)->format('H:i:s'),
                'checkout_time' => Carbon::parse($booking->checkout_time)->format('H:i:s'),
                'table_id' => $booking->table_id
            ];
        }

        return $bookingDetails;
    }

    // public function bookingpage($id)
    // {
    //     $tables = Table::where('restaurant_id', $id)->pluck('id');
    //     $booked = BookingRestaurant::where('restaurant_id', $id)->pluck('booking_date', 'table_id'); // 注意这里的键值对顺序
    //     $results = Table::where('restaurant_id',$id)->pluck('id', 'title');
    //     $genders = Gender::all();
    //     $restaurants = Restaurant::find($id);

    //     // 设置 $booking_date 变量，例如：
    //     $booking_date = date('Y-m-d'); // 以当前日期为例

    //     $tablesJson = json_encode($tables);
    //     $bookedJson = json_encode($booked);
    //     $resultsJson = json_encode($results);

    //     return view('auth.bookingrestaurant', compact('tables', 'restaurants', 'booked', 'results', 'genders', 'tablesJson', 'bookedJson', 'resultsJson', 'booking_date'));
    // }

    // // 将 isCheckInTimeExpired() 函数移到控制器类的顶部
    // function isCheckInTimeExpired($checkInTime)
    // {
    //     $checkInDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $checkInTime);
    //     $currentDateTime = Carbon::now();

    //     return $currentDateTime->diffInMinutes($checkInDateTime) >= 30;
    // }

    // public function booking(Request $request){

    //     $validator = Validator::make($request->all(), [
    //         'card_number' => 'required',
    //         'card_holder' => 'required',
    //         'card_month' => 'required',
    //         'card_year' => 'required',
    //         'cvv' => 'required',
    //         'booking_date' => 'required',
    //         'checkin_time' => 'required',
    //         'checkout_time' => 'required',
    //         'gender' => 'required',
    //         'quantity' => 'required|numeric|between:1,20', // 最小1，最大20
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     if(Auth::check()){

    //         try {
    //             // 验证用户输入数据

    //             // 开启数据库事务
    //             // DB::beginTransaction();

    //             // $resort_price = $request->resort_price;
    //             // $deposit_price = $resort_price * 0.1; // 获取resort_price的10

    //             // dd($deposit_price);

    //             // 存储支付卡信息
    //             $payment = new Deposit();
    //             $payment->user_name = $request->user()->name;
    //             $payment->user_email = $request->user()->email;
    //             $payment->type_name = $request->type_name;
    //             $payment->deposit_price = $request->deposit_price;
    //             $payment->card_number = $request->card_number;
    //             $payment->card_holder = $request->card_holder;
    //             $payment->card_month = $request->card_month;
    //             $payment->card_year = $request->card_year;
    //             $payment->cvv = $request->cvv;
    //             $payment->save();

    //             // Booking Restaurant save
    //             $restaurantId = $request->input('restaurant_id');

    //             $bookings = new BookingRestaurant();
    //             $bookings->user_id = auth()->id();
    //             $bookings->user_name = $request->user_name;
    //             $bookings->restaurant_id = $request->restaurant_id;
    //             $bookings->restaurant_name = $request->restaurant_name;
    //             $bookings->table_id = $request->table_id;

    //             $date = $request->booking_date;
    //             $time = $request->checkin_time;
    //             $dateTime = $date . ' ' . $time . ':00';
    //             $bookings->booking_date = $dateTime;
    //             $bookings->checkin_time = $request->checkin_time;
    //             $bookings->checkout_time = $request->checkout_time;
    //             $bookings->gender = $request->gender;
    //             $bookings->quantity = $request->quantity;
    //             $bookings->save();

    //             // 在保存后获取关联表格的标题
    //             $tableTitle = $bookings->table->title;

    //             $data = [
    //                 'subject' => 'You Booking Restaurant Detail',
    //                 'user_name' => $payment->user_name, // 使用 $payment->user_name
    //                 'email' => $payment->user_email, // 使用 $payment->user_email
    //                 'booking_date' => $dateTime,
    //                 'check_in_time' => $request->checkin_time,
    //                 'check_out_time' => $request->checkout_time,
    //                 'quantity' => $request->quantity,
    //                 'owner_name' => $request->owner_name,
    //                 'restaurant_email' => $request->restaurant_email,
    //                 'restaurant_phone' => $request->restaurant_phone,
    //                 'restaurant_name' => $request->restaurant_name,
    //                 'restaurant_type' => $request->restaurant_type,
    //                 'table_title' => $tableTitle,
    //             ];


    //             Mail::send('email.restaurantemail', $data, function($message) use ($data) {
    //                 $message->to('ahpin7762@gmail.com')
    //                 ->subject($data['subject']);
    //             });

    //             event(new BookingStatus());

    //             // return response()->json(['success' => '预订成功']);

    //             return back()->with('success', 'Booking created successfully!');

    //         }catch (\Exception $e) {
    //             // 发生异常时回滚事务
    //             DB::rollback();

    //             return back()->with('error', 'Booking failed: ' . $e->getMessage());
    //         }

    //     }else{

    //         return redirect()->route('frontend-auth.login')->with('error', 'You need to log in first.');
    //     }
    // }

    public function booking(Request $request){

        $validator = Validator::make($request->all(), [
            'card_number' => 'required|regex:/^\d{4} \d{4} \d{4} \d{4}$/',
            'card_holder' => 'required',
            'card_month' => 'required',
            'card_year' => 'required',
            'cvv' => 'required',
            'booking_date' => 'required',
            'checkin_time' => 'required',
            'checkout_time' => 'required',
            'gender' => 'required',
            'quantity' => 'required|numeric|between:1,20', // 最小1，最大20
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if(Auth::check()){

            try {

                $deposit = $request->deposit_price;
                $tax = $deposit * 0.10;
                $balance = $deposit - $tax;

                $verifyCode = Str::random(10);

                // Save Deposit Information
                $payment = new Deposit();
                $payment->user_name = $request->user()->name;
                $payment->user_email = $request->user()->email;
                $payment->type_name = $request->type_name;
                $payment->deposit_price = $deposit;
                $payment->total_price = 0;
                $payment->card_number = substr($request->card_number, -4);
                $payment->card_holder = $request->card_holder;
                $payment->card_month = $request->card_month;
                $payment->card_year = $request->card_year;
                $payment->cvv = Crypt::encryptString($request->cvv);
                $payment->save();

                // Booking Restaurant save
                $restaurantId = $request->input('restaurant_id');

                $bookings = new BookingRestaurant();
                $bookings->user_id = auth()->id();
                $bookings->user_name = $request->user_name;
                $bookings->restaurant_id = $request->restaurant_id;
                $bookings->restaurant_name = $request->restaurant_name;
                $bookings->table_id = $request->table_id;
                $bookings->booking_date = $request->booking_date;
                $bookings->checkin_time = $request->checkin_time;
                $bookings->checkout_time = $request->checkout_time;
                $bookings->gender = $request->gender;
                $bookings->quantity = $request->quantity;
                $bookings->deposit_price = $deposit;
                $bookings->card_number = substr($request->card_number, -4);
                $bookings->card_holder = $request->card_holder;
                $bookings->card_month = $request->card_month;
                $bookings->card_year = $request->card_year;
                $bookings->cvv = Crypt::encryptString($request->cvv);
                $bookings->verify_code = $verifyCode;
                $bookings->save();

                // 在保存后获取关联表格的标题
                $tableTitle = $bookings->table->title;

                // 更新管理员钱包
                $adminWallet = new AdminWallet();
                $adminWallet->type_id = $request->type_id;
                $adminWallet->type_name = $request->type_name;
                $adminWallet->type_category = $request->type_category;
                $adminWallet->user_deposit = $deposit;
                $adminWallet->balance = $balance;
                $adminWallet->tax = $tax;
                $adminWallet->verify_code = $verifyCode;
                $adminWallet->save();

                $data = [
                    'subject' => 'You Booking Restaurant Detail',
                    'user_name' => $payment->user_name, // 使用 $payment->user_name
                    'email' => $payment->user_email, // 使用 $payment->user_email
                    'booking_date' => $request->booking_date,
                    'check_in_time' => $request->checkin_time,
                    'check_out_time' => $request->checkout_time,
                    'quantity' => $request->quantity,
                    'owner_name' => $request->owner_name,
                    'restaurant_email' => $request->restaurant_email,
                    'restaurant_phone' => $request->restaurant_phone,
                    'restaurant_name' => $request->restaurant_name,
                    'restaurant_type' => $request->restaurant_type,
                    'table_title' => $tableTitle,
                ];

                Mail::send('email.restaurantemail', $data, function($message) use ($data) {
                    $message->to('ahpin7762@gmail.com')
                    ->subject($data['subject']);
                });

                event(new BookingStatus());

                // return response()->json(['success' => '预订成功']);

                return redirect()->route('frontend-restaurant')->with('success', "Restaurant {$bookings->restaurant_name} Booking successfully!");
                // return redirect()->route('frontend-restaurant')->with('success', "Restaurant {$bookings->restaurant_name} Booking successfully!");

            }catch (\Exception $e) {
                // 发生异常时回滚事务
                DB::rollback();

                return back()->with('error', 'Booking failed: ' . $e->getMessage());
            }

        }else{

            return redirect()->route('frontend-auth.login')->with('error', 'You need to log in first.');
        }
    }

    public function verifyRestaurantPayment(Request $request, $id)
    {
        $VerifyRestaurant = BookingRestaurant::with('restaurant', 'user')->findOrFail($id);

        // 获取从请求中传递过来的验证信息
        $user_id = $request->input('user_id');
        $restaurant_id = $request->input('restaurant_id');
        $checkin_date = $request->input('checkin_date');
        $checkout_date = $request->input('checkout_date');
        $verify_code = $request->input('verify_code');

        // 验证信息是否匹配
        if ($VerifyRestaurant->user_id == $user_id &&
            $VerifyRestaurant->restaurant_id == $restaurant_id &&
            $VerifyRestaurant->checkin_date == $checkin_date &&
            $VerifyRestaurant->checkout_date == $checkout_date &&
            $VerifyRestaurant->verify_code == $verify_code
        ) {
            // 如果匹配，则更新支付状态
            $VerifyRestaurant->payment_status = 1;
            $VerifyRestaurant->save();

            // 发送邮件到 ahpin7762@gmail.com
            Mail::to('ahpin7762@gmail.com')->send(new RestaurantPaymentVerification($VerifyRestaurant));

            // 返回之前的页面，并显示成功消息
            return redirect()->back()->with('success', 'Payment status updated successfully and verification information sent to your email.');
        } else {
            // 如果不匹配，则返回验证失败的信息
            return redirect()->back()->with('fail', 'Verify Fail, Information Verify Not Match.');
        }
    }

    public function checkoutRestaurant(Request $request, $bookingId)
    {
        try {
            DB::beginTransaction();

            // 获取预订信息
            $booking = BookingRestaurant::findOrFail($bookingId);
            $user = $booking->user;

            // 获取或创建用户钱包
            $userWallet = MyWallet::firstOrNew(['user_id' => $user->id]);

            // 获取Admin钱包并确保verify_code匹配
            $adminWallet = AdminWallet::where('verify_code', $booking->verify_code)->firstOrFail();

            // 将AdminWallet的balance转移到用户钱包的profit和balance
            $userWallet->profit += 0;
            $userWallet->balance += $adminWallet->balance;
            $adminWallet->refund_user_balance = $adminWallet->balance;
            $adminWallet->balance = 0;
            $adminWallet->transferred_status = 1;

            // 将AdminWallet的user_deposit转移到用户钱包的refund_deposit
            $userWallet->refund_deposit += $adminWallet->refund_user_balance;
            $adminWallet->refund_user_deposit = $adminWallet->balance;
            $adminWallet->user_deposit = 0;

            // 保存用户钱包和管理员钱包
            $userWallet->save();
            $adminWallet->save();

            // 更新预订状态
            $booking->payment_status = 2;
            $booking->save();

            DB::commit();

            return redirect()->back()->with('success', "Checked out successfully and deposit refunded!");

        } catch (\Exception $e) {

            DB::rollback();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    public function cancelBookingRestaurant(Request $request, $bookingId)
    {
        try {
            DB::beginTransaction();

            // 获取预订信息和用户信息
            $booking = BookingRestaurant::findOrFail($bookingId);
            $user = $booking->user;

            // 获取管理员钱包并确保verify_code匹配
            $adminWallet = AdminWallet::where('verify_code', $booking->verify_code)->firstOrFail();

            // 退款金额是预订价格的90%
            $user_deposit = $booking->deposit_price;

            $refundforadmin = $user_deposit * 0.1;
            $refundforuser = $user_deposit * 0.1;

            $refundAmount = $user_deposit - $refundforadmin - $refundforuser;

            // 获取或创建用户钱包
            $userWallet = MyWallet::firstOrNew(['user_id' => $user->id]);

            // 更新用户钱包余额和退款金额
            $userWallet->profit += $refundforuser;
            $userWallet->balance += $refundAmount;
            $userWallet->refund_price += $refundforuser;
            $userWallet->refund_deposit += $refundAmount; // 确保 refund_deposit 也更新
            $userWallet->save();

            // 更新管理员钱包余额和取消金额
            $adminWallet->refund_user_deposit += $refundAmount; // 确保管理员钱包记录了用户的退款金额
            $adminWallet->user_deposit = 0;
            $adminWallet->balance = 0;
            $adminWallet->save();

            // 更新预订状态
            $booking->payment_status = 3;
            $booking->save();

            DB::commit();

            return redirect()->back()->with('success', "Booking cancelled and refund processed!");

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Cancellation failed: ' . $e->getMessage());
        }
    }

    // Checkin_time Avaiable Table
    // public function checkBookings(Request $request)
    // {
    //     $checkInTime = $request->input('check_in_time');

    //     // Query the database to get the available tables based on the check-in time
    //     $availableTables = DB::table('tables')
    //         ->whereNotIn('id', function ($query) use ($checkInTime) {
    //             $query->select('table_id')
    //                   ->from('booking_restaurants')
    //                   ->where('check_in_time', $checkInTime);
    //         })
    //         ->get();

    //     $response = [
    //         'tables' => $availableTables,
    //     ];

    //     return response()->json($response);
    // }

    // Checkin_time Avaiable Table
    // public function checkdateBookings(Request $request)
    // {
    //     $CheckBookingTime = $request->input('booking_date');

    //     // Query the database to get the available tables based on the check-in time
    //     $availableTables = DB::table('tables')
    //         ->whereNotIn('id', function ($query) use ($CheckBookingTime) {
    //             $query->select('table_id')
    //                   ->from('booking_restaurants')
    //                   ->where('booking_date', $CheckBookingTime);
    //         })
    //         ->get();

    //     $response = [
    //         'tables' => $availableTables,
    //     ];

    //     return response()->json($response);
    // }

    // public function hasbookingRestaurant()
    // {
    //     $user = auth()->user();

    //     $restaurantIds = $user->restaurants()->pluck('id')->toArray();
    //     $hasBooked = BookingRestaurant::whereIn('restaurant_id', $restaurantIds)->get();
    //     $bookeds = $hasBooked->paginate(10);

    //     return view('user.bookings', compact('hasBooked','bookeds'));
    // }

    // public function hasbookingRestaurant()
    // {
    //     $user = auth()->user();

    //     $restaurantIds = $user->restaurants()->pluck('id')->toArray();

    //     // Get the query builder instance before fetching results
    //     $hasBookedQuery = BookingRestaurant::whereIn('restaurant_id', $restaurantIds);

    //     // Paginate the query builder instance
    //     $restaurantbookeds = $hasBookedQuery->paginate(10);

    //     // $bookedss = Restaurant::with('bookings', 'bookings.table')->get();

    //     return view('backend-user.hasbooked.bookedrestaurant', compact('restaurantbookeds'));
    // }

    public function hasbookingRestaurant()
    {
        $user = auth()->user();

        // Get the restaurant IDs booked by the user
        $restaurantIds = $user->restaurants()->pluck('id')->toArray();

        // Get the count of unpaid bookings for restaurants
        $unpaidRestaurantBookingsCount = BookingRestaurant::whereIn('restaurant_id', $restaurantIds)
            ->where('payment_status', 'unpaid')
            ->count();

        // Get the paginated list of booked restaurants
        $restaurantbookeds = BookingRestaurant::whereIn('restaurant_id', $restaurantIds)->paginate(10);

        return view('backend-user.hasbooked.bookedrestaurant', compact('restaurantbookeds', 'unpaidRestaurantBookingsCount'));
    }

    public function mybookedRestaurant()
    {
        $user = auth()->user();

        // $restaurantIds = $user->restaurants()->pluck('id')->toArray();

        // Get the query builder instance before fetching results
        $hasBookedQuery = BookingRestaurant::whereIn('user_id', $user);

        // Paginate the query builder instance
        $mybookeds = $hasBookedQuery->paginate(10);

        // $bookedss = Restaurant::with('bookings', 'bookings.table')->get();

        return view('backend-user.mybooked.mybookedrestaurant', compact('mybookeds'));
    }

    public function processPaymentRestaurant($id, $table_id)
    {
        // Get the booking restaurant record
        $restaurant = BookingRestaurant::find($id);

        // Check if the record exists
        if (!$restaurant) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Mark the restaurant payment as 'Paid'
        $restaurant->payment_status = 'Paid';
        $restaurant->save();

        // Update the status of the related table
        $table = Table::find($table_id);

        if ($table) {
            $table->status = 0;
            $table->save();
        }

        // Retrieve the associated deposit using the relationship
        $deposit = $restaurant->deposit;

        // Check if deposit record exists
        if ($deposit) {
            // Update the deposit status to '1' (assuming 'status' is a boolean field)
            $deposit->status = 1;
            $deposit->save();

        } else {

            return back()->with('error', 'Deposit record not found.');
        }

        // 发送电子邮件
        $data = [
            'subject' => 'You Booking Restaurant Deposit Refund',
            'user_name' => $restaurant->deposit->user_name,
            'email' => $restaurant->deposit->user_email,
            'deposit_price' => $restaurant->deposit->deposit_price,
            'restaurant_name' => $restaurant->restaurant_name,
            'card_number' => $restaurant->deposit->card_number,
            'card_holder' => $restaurant->deposit->card_holder,
            'card_month' => $restaurant->deposit->card_month,
            'card_year' => $restaurant->deposit->card_year,
            'cvv' => $restaurant->deposit->cvv,
        ];

        Mail::send('email.restaurantdepositrefundemail', $data, function($message) use ($data) {
            $message->to('ahpin7762@gmail.com')
            ->subject($data['subject']);
        });

        // Redirect back with success message
        return redirect()->back()->with('success', 'Payment processed successfully.');
    }

    public function viewBookedRestaurant($id){

        $bookedrestaurants = BookingRestaurant::find($id);

        return view('backend-user.hasbooked.viewbookedrestaurant',compact('bookedrestaurants'));
    }

    public function hasrestaurantSearch(Request $request)
    {
        // Retrieve the input values from the request
        // $name = $request->input('name');
        // $country = $request->input('country');
        // $state = $request->input('state');
        // $address = $request->input('address');
        // $price = $request->input('price');

        // Build your database query based on the input values
        // $query = Hotel::query();

        $user = auth()->user();

        $restaurantIds = $user->restaurants()->pluck('id')->toArray();

        // Get the query builder instance before fetching results
        $hasBookedQuery = BookingRestaurant::whereIn('restaurant_id', $restaurantIds);

        // Paginate the query builder instance
        $bookeds = $hasBookedQuery->paginate(10);

        // Build your database query based on the input values
        $query = BookingRestaurant::query();

        if ($request->restaurant_name) {
            $query->where('restaurant_name', 'LIKE', '%' . $request->restaurant_name . '%');
        }

        if ($request->user_name) {
            $query->where('user_name', 'LIKE', '%' . $request->user_name . '%');
        }

        if ($request->booking_date) {
            $query->whereDate('booking_date', '=', $request->booking_date);
        }

        if ($request->check_in_time && $request->check_out_time) {
            $query->where(function ($query) use ($request) {
                $query->where('checkin_time', '>=', $request->check_in_time)
                    ->where('checkout_time', '<=', $request->check_out_time);
            });
        }


        // Execute the query and retrieve the results
        $bookeds = $query->paginate(10);

        // Execute the query
        // $results = $query->get();
        // dd($result);
        // {{ dd($results) }}

        return view('backend-user.hasbooked.bookedrestaurant', compact('bookeds'));
    }

    public function deleteMultiplebookedrestaurant(Request $request)
    {
        $ids = json_decode($request->input('ids'));

        if (is_array($ids) && count($ids) > 0) {

            BookingRestaurant::whereIn('id', $ids)->delete();

            return back()->with('success', 'Selected Booked Restaurants have been deleted successfully!');

        } else {

            return back()->with('error', 'Invalid input. No Booked Restaurants were deleted.');
        }
    }

    public function customerdeleteMultiplebookedrestaurant(Request $request)
    {
        $ids = json_decode($request->input('ids'));

        if (is_array($ids) && count($ids) > 0) {

            BookingRestaurant::whereIn('id', $ids)->delete();

            return back()->with('success', 'Selected Customer Booked Restaurants have been deleted successfully!');

        } else {

            return back()->with('error', 'Invalid input. No Customer Booked Restaurants were deleted.');
        }
    }

    //------------------------------------------------ Frontend Booking Resort Area --------------------------------------------------//

    public function bookingresortpage(Request $request, $id)
    {
        if (Auth::check()) {

            $genders = Gender::all();
            $resorts = Resort::find($id);

            // 获取已预订的日期范围
            $bookedDates = $this->getBookedResortDates($id);

            return view('frontend-auth.frontend-resort.bookingresort', compact('resorts', 'genders', 'bookedDates'));

        } else {

            return redirect()->route('frontend-auth.login')->with('error', 'You need to log in first.');
        }
    }

    // 在需要的地方设置Stripe API密钥，例如在控制器的构造函数中
    // public function __construct()
    // {
    //     $stripeSecretKey = config('services.stripe.sk');
    //     // dd([
    //     //     'stripe_key_from_env' => env('STRIPE_KEY'),
    //     //     'stripe_secret_from_env' => env('STRIPE_SECRET'),
    //     //     'stripe_key_from_config' => config('services.stripe.pk'),
    //     //     'stripe_secret_from_config' => $stripeSecretKey,
    //     // ]);

    //     Stripe::setApiKey($stripeSecretKey);
    //     Log::info('Stripe API Key set: ' . $stripeSecretKey);
    // }

    // public function bookingresortpage(Request $request, $id)
    // {
    //     if (Auth::check()) {
    //         $resorts = Resort::find($id);
    //         $genders = Gender::all();

    //         // 获取已预订的日期范围
    //         $bookedDates = $this->getBookedResortDates($id);

    //         // 获取Stripe的Publishable Key
    //         $stripeKey = env('STRIPE_KEY');  // 直接从环境变量获取

    //         // 确保 $resorts、$genders、$bookedDates 和 $stripeKey 都有值
    //         $data = [
    //             'resorts' => $resorts,
    //             'genders' => $genders,
    //             'bookedDates' => $bookedDates,
    //             'stripeKey' => $stripeKey, // 确保这里赋值了正确的Stripe公钥
    //         ];

    //         return view('frontend-auth.frontend-resort.bookingresort', $data);
    //     } else {
    //         return redirect()->route('frontend-auth.login')->with('error', 'You need to log in first.');
    //     }
    // }

    // 获取指定度假村的已预订的日期范围
    public function getBookedResortDates($resortId)
    {
        // 查询数据库中指定度假村已预订的日期范围
        $bookings = BookingResort::where('resort_id', $resortId)->get(); // 获取指定度假村的所有预订信息

        $bookedDates = [];

        // 遍历所有预订信息，将日期范围添加到 $bookedDates 数组中
        foreach ($bookings as $booking) {
            $checkinDate = Carbon::parse($booking->checkin_date); // 转换为 Carbon 对象
            $checkoutDate = Carbon::parse($booking->checkout_date); // 转换为 Carbon 对象

            // 将日期范围添加到 $bookedDates 数组中
            while ($checkinDate->lte($checkoutDate)) {
                $bookedDates[] = $checkinDate->format('Y-m-d');
                $checkinDate->addDay(); // 将日期增加一天
            }
        }

        return $bookedDates;
    }

    public function bookingresort(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_number' => 'required|regex:/^\d{4} \d{4} \d{4} \d{4}$/',
            'card_holder' => 'required',
            'card_month' => 'required|integer|between:1,12',
            'card_year' => 'required|integer|min:' . date('Y'),
            'cvv' => 'required|digits:3',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after_or_equal:checkin_date',
            'checkin_time' => 'required|date_format:H:i',
            'checkout_time' => 'required|date_format:H:i',
            'gender' => 'required',
            'quantity' => 'required|numeric|between:1,20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::check()) {
            try {
                DB::beginTransaction();

                $checkinDate = Carbon::parse($request->checkin_date);
                $checkoutDate = Carbon::parse($request->checkout_date);
                $bookingDays = $checkoutDate->diffInDays($checkinDate);

                $totalPrice = $request->resort_price * $bookingDays;

                $tax = $totalPrice * 0.10;
                $deposit = $request->deposit_price;
                $balance = $totalPrice - $tax;

                $verifyCode = Str::random(10);

                // Save Deposit Information
                $payment = new Deposit();
                $payment->user_name = $request->user()->name;
                $payment->user_email = $request->user()->email;
                $payment->type_name = $request->type_name;
                $payment->deposit_price = $deposit;
                $payment->total_price = $totalPrice;
                $payment->card_number = substr($request->card_number, -4);
                $payment->card_holder = $request->card_holder;
                $payment->card_month = $request->card_month;
                $payment->card_year = $request->card_year;
                $payment->cvv = Crypt::encryptString($request->cvv);
                $payment->save();

                // Save Booking Resort Information
                $booking = new BookingResort();
                $booking->user_id = auth()->id();
                $booking->user_name = $request->user()->name;
                $booking->resort_id = $request->resort_id;
                $booking->resort_name = $request->resort_name;
                $booking->gender = $request->gender;
                $booking->quantity = $request->quantity;
                $booking->checkin_date = $request->checkin_date;
                $booking->checkout_date = $request->checkout_date;
                $booking->booking_days = $bookingDays;
                $booking->checkin_time = $request->checkin_time;
                $booking->checkout_time = $request->checkout_time;
                $booking->deposit_price = $deposit;
                $booking->total_price = $totalPrice;
                $booking->card_number = substr($request->card_number, -4);
                $booking->card_holder = $request->card_holder;
                $booking->card_month = $request->card_month;
                $booking->card_year = $request->card_year;
                $booking->cvv = Crypt::encryptString($request->cvv);
                $booking->verify_code = $verifyCode;
                $booking->save();

                // 更新管理员钱包
                $adminWallet = new AdminWallet();
                $adminWallet->type_id = $request->type_id;
                $adminWallet->type_name = $request->type_name;
                $adminWallet->type_category = $request->type_category;
                $adminWallet->balance = $balance;
                $adminWallet->user_deposit = $deposit;
                $adminWallet->tax = $tax;
                $adminWallet->verify_code = $verifyCode;
                $adminWallet->save();

                $data = [
                    'subject' => 'Your Booking Resort Details',
                    'user_name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'booking_days' => $bookingDays,
                    'check_in_date' => $request->checkin_date,
                    'check_out_date' => $request->checkout_date,
                    'check_in_time' => $request->checkin_time,
                    'check_out_time' => $request->checkout_time,
                    'quantity' => $request->quantity,
                    'gender' => $request->gender,
                    'owner_name' => $request->owner_name,
                    'resort_name' => $request->resort_name,
                    'resort_phone' => $request->resort_phone,
                    'resort_email' => $request->resort_email,
                    'resort_price' => $request->resort_price,
                    'total_price' => $totalPrice,
                    'resort_type' => $request->resort_type,
                ];

                Mail::send('email.resortemail', $data, function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['subject']);
                });

                DB::commit();

                event(new BookingStatus());

                return redirect()->route('home')->with('success', "Resort {$booking->resort_name} booked successfully!");
            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('error', 'Booking failed: ' . $e->getMessage());
            }
        } else {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    }

    public function verifyResortPayment(Request $request, $id)
    {
        $VerifyResort = BookingResort::with('resort', 'user')->findOrFail($id);

        // 获取从请求中传递过来的验证信息
        $user_id = $request->input('user_id');
        $resort_id = $request->input('resort_id');
        $checkin_date = $request->input('checkin_date');
        $checkout_date = $request->input('checkout_date');
        $total_price = $request->input('total_price');
        $verify_code = $request->input('verify_code');

        // 验证信息是否匹配
        if ($VerifyResort->user_id == $user_id &&
            $VerifyResort->resort_id == $resort_id &&
            $VerifyResort->checkin_date == $checkin_date &&
            $VerifyResort->checkout_date == $checkout_date &&
            $VerifyResort->total_price == $total_price &&
            $VerifyResort->verify_code == $verify_code
        ) {
            // 如果匹配，则更新支付状态
            $VerifyResort->payment_status = 1;
            $VerifyResort->save();

            // 发送邮件到 ahpin7762@gmail.com
            Mail::to('ahpin7762@gmail.com')->send(new ResortPaymentVerification($VerifyResort));

            // 返回之前的页面，并显示成功消息
            return redirect()->back()->with('success', 'Payment status updated successfully and verification information sent to your email.');
        } else {
            // 如果不匹配，则返回验证失败的信息
            return redirect()->back()->with('fail', 'Verify Fail, Information Verify Not Match.');
        }
    }

    public function checkoutResort(Request $request, $bookingId)
    {
        try {
            DB::beginTransaction();

            $booking = BookingResort::findOrFail($bookingId);
            $user = $booking->user;

            $userWallet = MyWallet::firstOrNew(['user_id' => $user->id]);
            $adminWallet = AdminWallet::where('verify_code', $booking->verify_code)->firstOrFail();

            $userWallet->profit += $adminWallet->balance;
            $userWallet->balance += $adminWallet->balance;
            $adminWallet->refund_user_balance = $adminWallet->balance;
            $adminWallet->balance = 0;
            $adminWallet->transferred_status = 1;

            $userWallet->refund_deposit += $adminWallet->user_deposit;
            $adminWallet->refund_user_deposit = $adminWallet->user_deposit;
            $adminWallet->user_deposit = 0;

            $userWallet->save();
            $adminWallet->save();

            $booking->payment_status = 2;
            $booking->save();

            DB::commit();

            return redirect()->back()->with('success', "Checked out successfully and deposit refunded!");

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    public function cancelBookingResort(Request $request, $bookingId)
    {
        try {
            DB::beginTransaction();

            // 获取预订信息和用户信息
            $booking = BookingResort::findOrFail($bookingId);
            $user = $booking->user;

            // 获取管理员钱包并确保verify_code匹配
            $adminWallet = AdminWallet::where('verify_code', $booking->verify_code)->firstOrFail();

            // 退款金额是预订价格的90%
            $refundAmount = $booking->total_price * 0.90;

            // 获取或创建用户钱包
            $userWallet = MyWallet::firstOrNew(['user_id' => $user->id]);

            // 更新用户钱包余额和退款金额
            $userWallet->balance += $refundAmount;
            $userWallet->refund_price += $refundAmount;
            $userWallet->save();

            // 更新管理员钱包余额和取消金额
            $adminWallet->balance -= $refundAmount;
            $adminWallet->user_cancel_balance += $refundAmount;
            $adminWallet->save();

            // 更新预订状态
            $booking->payment_status = 3;
            $booking->save();

            DB::commit();

            return redirect()->back()->with('success', "Booking cancelled and refund processed!");

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Cancellation failed: ' . $e->getMessage());
        }
    }

    // public function bookingresort(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'card_number' => 'required|regex:/^\d{4} \d{4} \d{4} \d{4}$/',
    //         'card_holder' => 'required',
    //         'card_month' => 'required',
    //         'card_year' => 'required',
    //         'cvv' => 'required',
    //         'checkin_date' => 'required',
    //         'checkout_date' => 'required',
    //         'checkin_time' => 'required',
    //         'checkout_time' => 'required',
    //         'gender' => 'required',
    //         'quantity' => 'required|numeric|between:1,20',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     if (Auth::check()) {
    //         try {
    //             DB::beginTransaction();

    //             // Calculate booking days and total price
    //             $checkinDate = Carbon::parse($request->checkin_date);
    //             $checkoutDate = Carbon::parse($request->checkout_date);
    //             $bookingDays = $checkoutDate->diffInDays($checkinDate);
    //             $totalPrice = $bookingDays * $request->resort_price * 100; // Convert to cents

    //             dd($totalPrice);

    //             \Log::debug('Total Price in Cents: ', ['totalPrice' => $totalPrice]);

    //             // 设置Stripe API密钥
    //             Stripe::setApiKey(config('services.stripe.sk'));

    //             // 创建PaymentIntent
    //             $paymentIntent = PaymentIntent::create([
    //                 'amount' => $totalPrice,
    //                 'currency' => 'myr',
    //                 'description' => 'Resort Booking: ' . $request->resort_name,
    //                 'payment_method_types' => ['card'],
    //             ]);

    //             \Log::info('PaymentIntent Created: ', ['paymentIntentId' => $paymentIntent->id]);

    //             // 将PaymentIntent的client_secret返回给前端
    //             $clientSecret = $paymentIntent->client_secret;

    //             // 存储payment_intent_id以便稍后查找和确认支付
    //             $paymentIntentId = $paymentIntent->id;

    //             // 暂时保存用户的预定信息，等待支付完成
    //             $payment = new Deposit();
    //             $payment->user_name = $request->user()->name;
    //             $payment->user_email = $request->user()->email;
    //             $payment->type_name = $request->type_name;
    //             $payment->deposit_price = $request->deposit_price;
    //             $payment->card_number = $request->card_number;
    //             $payment->card_holder = $request->card_holder;
    //             $payment->card_month = $request->card_month;
    //             $payment->card_year = $request->card_year;
    //             $payment->cvv = $request->cvv;
    //             $payment->payment_intent_id = $paymentIntentId;
    //             $payment->save();

    //             // Store booking info
    //             $booking = new BookingResort();
    //             $booking->user_id = auth()->id();
    //             $booking->user_name = $request->user()->name;
    //             $booking->resort_id = $request->resort_id;
    //             $booking->resort_name = $request->resort_name;
    //             $booking->gender = $request->gender;
    //             $booking->quantity = $request->quantity;
    //             $booking->checkin_date = $request->checkin_date;
    //             $booking->checkout_date = $request->checkout_date;
    //             $booking->booking_days = $bookingDays;
    //             $booking->checkin_time = $request->checkin_time;
    //             $booking->checkout_time = $request->checkout_time;
    //             $booking->deposit_price = $request->deposit_price;
    //             $booking->card_number = $request->card_number;
    //             $booking->card_holder = $request->card_holder;
    //             $booking->card_month = $request->card_month;
    //             $booking->card_year = $request->card_year;
    //             $booking->cvv = $request->cvv;
    //             $booking->payment_intent_id = $paymentIntentId;
    //             $booking->save();

    //             // Send email
    //             $data = [
    //                 'subject' => 'Your Booking Resort Details',
    //                 'user_name' => $request->user()->name,
    //                 'email' => $request->user()->email,
    //                 'booking_days' => $bookingDays,
    //                 'check_in_date' => $request->checkin_date,
    //                 'check_out_date' => $request->checkout_date,
    //                 'check_in_time' => $request->checkin_time,
    //                 'check_out_time' => $request->checkout_time,
    //                 'quantity' => $request->quantity,
    //                 'gender' => $request->gender,
    //                 'owner_name' => $request->owner_name,
    //                 'resort_name' => $request->resort_name,
    //                 'resort_phone' => $request->resort_phone,
    //                 'resort_email' => $request->resort_email,
    //                 'resort_price' => $request->resort_price,
    //                 'total_price' => $totalPrice / 100,
    //                 'resort_type' => $request->resort_type,
    //             ];

    //             Mail::send('email.resortemail', $data, function ($message) use ($data) {
    //                 $message->to($data['email'])->subject($data['subject']);
    //             });

    //             DB::commit();

    //             event(new BookingStatus());

    //             return redirect()->route('home')->with('success', "Resort {$booking->resort_name} Booking successfully!");

    //             // return response()->json([
    //             //     'client_secret' => $clientSecret,
    //             //     'message' => 'Payment Intent created. Please complete the payment.',
    //             // ]);

    //         } catch (ApiErrorException $e) {
    //             DB::rollback();
    //             \Log::error('Stripe API Error: ', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    //             return response()->json(['error' => 'Payment failed: ' . $e->getMessage()], 500);
    //         } catch (\Exception $e) {
    //             DB::rollback();
    //             \Log::error('General Error: ', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    //             return response()->json(['error' => 'Booking failed: ' . $e->getMessage()], 500);
    //         }
    //     } else {
    //         return response()->json(['error' => 'You need to log in first.'], 401);
    //     }
    // }

    public function hasbookingResort()
    {
        $user = auth()->user();

        // Get the resort IDs booked by the user
        $resortIds = $user->resorts()->pluck('id')->toArray();

        // Get the count of unpaid bookings for resorts
        $unpaidResortBookingsCount = BookingResort::whereIn('resort_id', $resortIds)
            ->where('payment_status', 'unpaid')
            ->count();

        // Get the paginated list of booked resorts
        $resortbookeds = BookingResort::whereIn('resort_id', $resortIds)->paginate(10);

        return view('backend-user.hasbooked.bookedresort', compact('resortbookeds', 'unpaidResortBookingsCount'));
    }

    public function mybookedResort()
    {
        $user = auth()->user();

        // $restaurantIds = $user->restaurants()->pluck('id')->toArray();

        // Get the query builder instance before fetching results
        $hasBookedQuery = BookingResort::whereIn('user_id', $user);

        // Paginate the query builder instance
        $mybookeds = $hasBookedQuery->paginate(10);

        // $bookedss = Restaurant::with('bookings', 'bookings.table')->get();

        return view('backend-user.mybooked.mybookedresort', compact('mybookeds'));
    }

    public function processPaymentResort($id)
    {
        // Get the booked resort record
        $resort = BookingResort::find($id);

        // Check if the record exists
        if (!$resort) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Mark the resort payment as 'Paid'
        // $resort_name = $resort->resort_name;
        $resort->payment_status = 'Paid';
        $resort->save();

        // Find the associated resort using the relationship
        $associatedResort = $resort->resort;

        // Check if resort record exists
        if ($associatedResort) {
            // Update the resort status to '1'
            $associatedResort->status = 0;
            $associatedResort->save();

        } else {

            return back()->with('error', 'Resort record not found.');
        }

        // Retrieve the associated deposit using the relationship
        $deposit = $resort->deposit;

        // $user_name = $resort->deposit->user_name;
        // $email = $resort->deposit->user_email;
        // $deposit_price = $resort->deposit->deposit_price;
        // $card_number = $resort->deposit->card_number;
        // $card_holder = $resort->deposit->card_holder;
        // $card_month = $resort->deposit->card_month;
        // $card_year = $resort->deposit->card_year;
        // $cvv = $resort->deposit->cvv;

        // Check if deposit record exists
        if ($deposit) {
            // Update the deposit status to '1' (assuming 'status' is a boolean field)
            $deposit->status = 1;
            $deposit->save();

        } else {

            return back()->with('error', 'Deposit record not found.');
        }

        // 发送电子邮件
        $data = [
            'subject' => 'You Booking Resort Deposit Refund',
            'user_name' => $resort->deposit->user_name,
            'email' => $resort->deposit->user_email,
            'deposit_price' => $resort->deposit->deposit_price,
            'resort_name' => $resort->resort_name,
            'card_number' => $resort->deposit->card_number,
            'card_holder' => $resort->deposit->card_holder,
            'card_month' => $resort->deposit->card_month,
            'card_year' => $resort->deposit->card_year,
            'cvv' => $resort->deposit->cvv,
        ];

        Mail::send('email.resortdepositrefundemail', $data, function($message) use ($data) {
            $message->to('ahpin7762@gmail.com')
            ->subject($data['subject']);
        });

        // Redirect back with success message
        return redirect()->back()->with('success', 'Payment processed successfully.');
    }

    public function viewBookedResort($id){

        $bookedresorts = BookingResort::find($id);

        return view('backend-user.hasbooked.viewbookedresort',compact('bookedresorts'));
    }

    public function hasresortSearch(Request $request)
    {
        // Retrieve the input values from the request
        // $name = $request->input('name');
        // $country = $request->input('country');
        // $state = $request->input('state');
        // $address = $request->input('address');
        // $price = $request->input('price');

        // Build your database query based on the input values
        // $query = Hotel::query();

        $user = auth()->user();

        $resortIds = $user->restaurants()->pluck('id')->toArray();

        // Get the query builder instance before fetching results
        $hasBookedQuery = BookingResort::whereIn('resort_id', $resortIds);

        // Paginate the query builder instance
        $bookeds = $hasBookedQuery->paginate(10);

        // Build your database query based on the input values
        $query = BookingResort::query();

        if ($request->resort_name) {
            $query->where('resort_name', 'LIKE', '%' . $request->resort_name . '%');
        }

        if ($request->user_name) {
            $query->where('User_name', 'LIKE', '%' . $request->user_name . '%');
        }

        if ($request->booking_date) {
            $query->whereDate('booking_date', '=', $request->booking_date);
        }

        if ($request->check_in_time && $request->check_out_time) {
            $query->where(function ($query) use ($request) {
                $query->where('checkin_time', '>=', $request->check_in_time)
                    ->where('checkout_time', '<=', $request->check_out_time);
            });
        }

        // Execute the query and retrieve the results
        $bookeds = $query->paginate(10);

        // Execute the query
        // $results = $query->get();
        // dd($result);
        // {{ dd($results) }}

        return view('backend-user.hasbooked.bookedresort', compact('bookeds'));
    }

    public function deleteMultiplebookedresort(Request $request)
    {
        $ids = json_decode($request->input('ids'));

        if (is_array($ids) && count($ids) > 0) {

            BookingResort::whereIn('id', $ids)->delete();

            return back()->with('success', 'Selected Booked Resorts have been deleted successfully!');

        } else {

            return back()->with('error', 'Invalid input. No Booked Resorts were deleted.');
        }
    }

    // -------------------------------------------------Frontend Booking Hotel Area-----------------------------------------------------//

    // public function bookinghotelpage(Request $request, $id)
    // {
    //     if(Auth::check()){

    //         // $genders = Gender::all();
    //         // $hotels = Hotel::find($id);

    //         $rooms = Room::where('hotel_id', $id)->pluck('id');
    //         // $rooms = Room::where('hotel_id', $id)->select('id', 'name', 'price')->get();

    //         $bookedData = BookingHotel::where('hotel_id', $id)
    //             ->get()
    //             ->groupBy('booking_date')
    //             ->map(function ($bookings) {
    //                 return $bookings->pluck('room_id')->toArray();
    //             });

    //         $booked = $bookedData->toArray();
    //         // $results = Room::where('hotel_id',$id)->pluck('id','name');
    //         // $roomprice = Room::where('hotel_id',$id)->pluck('id','price');
    //         // $item1=Room::where('hotel_id', $id)->pluck('id','price');
    //         // $item2=Room::where('hotel_id', $id)->pluck('name');
    //         // $results = $item1 -> merge($item2);

    //         $results = Room::where('hotel_id', $id)->select('id', 'name', 'price','type')->get();
    //         $collectionBooked = collect($booked);
    //         $collectionResults = collect($results);

    //         // dd($results);
    //         $genders = Gender::all();
    //         $hotels = Hotel::find($id);

    //         // dd($booking_date);
    //         // dd($results);

    //         // 设置 $booking_date 变量，例如：
    //         $booking_date = date('Y-m-d'); // 以当前日期为例

    //         // $hotel_price = $request->hotel_price;
    //         // $deposit_price = $hotel_price * 0.1;

    //     }else{

    //         return redirect()->route('frontend-auth.login')->with('error', 'You need to log in first.');
    //     }
    //         return view('frontend-auth.frontend-hotel.bookinghotel',compact('hotels','genders','rooms','results','booked','collectionBooked','collectionResults'));
    // }

    // Special Code
    // public function bookinghotelpage(Request $request, $id)
    // {
    //     if (Auth::check())
    //     {
    //         $rooms = Room::where('hotel_id', $id)
    //             ->where('status', 0)
    //             ->get();

    //         $genders = Gender::all();
    //         $hotels = Hotel::find($id);

    //         // 获取已预订的日期范围
    //         $bookedDates = $this->getBookedHotelDates($id);

    //     } else {

    //         return redirect()->route('frontend-auth.login')->with('error', 'You need to log in first.');
    //     }
    //         return view('frontend-auth.special.bookinghotel',compact('hotels','genders','rooms','bookedDates'));
    // }

    public function bookinghotelpage(Request $request, $id)
    {
        if (Auth::check())
        {
            $rooms = Room::where('hotel_id', $id)
                ->where('status', 0)
                ->get();

            $genders = Gender::all();
            $hotels = Hotel::find($id);

            // 获取已预订的日期范围
            $bookedDates = $this->getBookedHotelDates($id);

            // dd($bookedDates);

            return view('frontend-auth.special.bookinghotel', compact('hotels', 'genders', 'rooms', 'bookedDates'));
        } else {
            return redirect()->route('frontend-auth.login')->with('error', 'You need to log in first.');
        }
    }

    // 获取指定度假村的已预订的日期范围
    // public function getBookedHotelDates($hotelId)
    // {
    //     // 查询数据库中指定度假村已预订的日期范围
    //     $bookings = BookingHotel::where('hotel_id', $hotelId)->get(); // 获取指定度假村的所有预订信息

    //     $bookedDates = [];

    //     // 遍历所有预订信息，将日期范围添加到 $bookedDates 数组中
    //     foreach ($bookings as $booking) {
    //         $checkinDate = Carbon::parse($booking->checkin_date); // 转换为 Carbon 对象
    //         $checkoutDate = Carbon::parse($booking->checkout_date); // 转换为 Carbon 对象

    //         // 将日期范围添加到 $bookedDates 数组中
    //         while ($checkinDate->lte($checkoutDate)) {
    //             $bookedDates[] = $checkinDate->format('Y-m-d');
    //             $checkinDate->addDay(); // 将日期增加一天
    //         }
    //     }

    //     return $bookedDates;
    // }

    public function getBookedHotelDates($hotelId)
    {
        // 获取该酒店所有房间的预订信息
        $bookings = BookingHotel::whereHas('room', function ($query) use ($hotelId) {
            $query->where('hotel_id', $hotelId);
        })->get();

        // 生成预订日期和房间ID的数组
        $bookedDates = [];

        // dd($bookedDates);

        foreach ($bookings as $booking) {
            $period = new \DatePeriod(
                new \DateTime($booking->checkin_date),
                new \DateInterval('P1D'),
                (new \DateTime($booking->checkout_date))->modify('+1 day')
            );

            foreach ($period as $date) {
                $bookedDates[] = [
                    'room_id' => $booking->room_id,
                    'date' => $date->format('Y-m-d')
                ];
            }
        }

        return $bookedDates;
    }

    public function bookinghotel(Request $request){

        $validator = Validator::make($request->all(), [
            'card_number' => 'required|regex:/^\d{4} \d{4} \d{4} \d{4}$/',
            'card_holder' => 'required',
            'card_month' => 'required',
            'card_year' => 'required',
            'cvv' => 'required|digits:3',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after_or_equal:checkin_date',
            'checkin_time' => 'required|date_format:H:i',
            'checkout_time' => 'required|date_format:H:i',
            'gender' => 'required',
            'quantity' => 'required|numeric|between:1,20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Convert card_month to integer
        $cardMonth = (int) $request->card_month;
        $cardYear = (int) $request->card_year;

        if(Auth::check()){

            try{

                // 验证用户输入数据

                // 开启数据库事务
                DB::beginTransaction();

                // 获取入住日期和退房日期并转换为 Carbon 对象
                $checkinDate = Carbon::parse($request->checkin_date);
                $checkoutDate = Carbon::parse($request->checkout_date);

                // 计算日期差
                $bookingDays = $checkoutDate->diffInDays($checkinDate);

                $totalPrice = $request->room_price * $bookingDays;

                $tax = $totalPrice * 0.10;
                $deposit = $request->deposit_price;
                $balance = $totalPrice - $tax;

                $verifyCode = Str::random(10);

                // 存储支付卡信息
                $payment = new Deposit();
                $payment->user_name = $request->user()->name;
                $payment->user_email = $request->user()->email;
                $payment->type_name = $request->type_name;
                $payment->deposit_price = $deposit;
                $payment->total_price = $totalPrice;
                $payment->card_number = substr($request->card_number, -4);
                $payment->card_holder = $request->card_holder;
                $payment->card_month = $cardMonth; // 使用转换后的整数
                $payment->card_year = $cardYear; // 使用转换后的整数
                $payment->cvv = Crypt::encryptString($request->cvv);
                $payment->save();

                $bookings = new BookingHotel();
                $bookings->user_id = auth()->id();
                $bookings->user_name = $request->user_name;
                $bookings->hotel_id = $request->hotel_id;
                $bookings->hotel_name = $request->hotel_name;
                $bookings->room_id = $request->room_id;
                $bookings->booking_days = $bookingDays;
                $bookings->checkin_date = $request->checkin_date;
                $bookings->checkout_date = $request->checkout_date;
                $bookings->checkin_time = $request->checkin_time;
                $bookings->checkout_time = $request->checkout_time;
                $bookings->gender = $request->gender;
                $bookings->quantity = $request->quantity;
                $bookings->deposit_price = $deposit;
                $bookings->total_price = $totalPrice;
                $bookings->card_number = substr($request->card_number, -4);
                $bookings->card_holder = $request->card_holder;
                $bookings->card_month = $cardMonth; // 使用转换后的整数
                $bookings->card_year = $cardYear; // 使用转换后的整数
                $bookings->cvv = Crypt::encryptString($request->cvv);
                $bookings->verify_code = $verifyCode;
                $bookings->save();

                // 在保存后获取关联表格的标题
                $roomTitle = $bookings->room->name;
                $roomType = $bookings->room->type;
                $roomPrice = $bookings->room->price;

                // 更新管理员钱包
                $adminWallet = new AdminWallet();
                $adminWallet->type_id = $request->type_id;
                $adminWallet->type_name = $request->type_name;
                $adminWallet->type_category = $request->type_category;
                $adminWallet->balance = $balance;
                $adminWallet->user_deposit = $deposit;
                $adminWallet->tax = $tax;
                $adminWallet->verify_code = $verifyCode;
                $adminWallet->save();

                $data = [
                    'subject' => 'You Booking Hotel Detail',
                    'user_name' => $request->user_name,
                    'email' => $request->email,
                    'booking_days' => $bookingDays,
                    'check_in_date' => $request->checkinDate,
                    'check_out_date' => $request->checkoutDate,
                    'check_in_time' => $request->checkin_time,
                    'check_out_time' => $request->checkout_time,
                    'quantity' => $request->quantity,
                    'owner_name' => $request->owner_name,
                    'hotel_email' => $request->hotel_email,
                    'hotel_phone' => $request->hotel_phone,
                    'hotel_name' => $request->hotel_name,
                    'hotel_type' => $request->hotel_type,
                    'room_name' => $roomTitle,
                    'room_type' => $roomType,
                    'room_price' => $roomPrice,
                    'total_price' => $totalPrice,
                ];

                Mail::send('email.hotelemail', $data, function($message) use ($data) {
                    $message->to('ahpin7762@gmail.com')
                    ->subject($data['subject']);
                });

                // 提交数据库事务
                DB::commit();

                event(new BookingStatus());

                return redirect()->route('frontend-hotel')->with('success', "Hotel {$bookings->hotel_name} Booking successfully!");

            } catch (Exception $e) {
                // 发生异常时回滚事务
                DB::rollback();

                return back()->with('error', 'Booking failed: ' . $e->getMessage());
            }

        } else {
            return redirect()->route('frontend-auth.login')->with('error', 'You need to log in first.');
        }
    }

    public function verifyHotelPayment(Request $request, $id)
    {
        $VerifyHotel = BookingHotel::with('hotel', 'user')->findOrFail($id);

        // 获取从请求中传递过来的验证信息
        $user_id = $request->input('user_id');
        $hotel_id = $request->input('hotel_id');
        $checkin_date = $request->input('checkin_date');
        $checkout_date = $request->input('checkout_date');
        $total_price = $request->input('total_price');
        $verify_code = $request->input('verify_code');

        // 验证信息是否匹配
        if ($VerifyHotel->user_id == $user_id &&
            $VerifyHotel->hotel_id == $hotel_id &&
            $VerifyHotel->checkin_date == $checkin_date &&
            $VerifyHotel->checkout_date == $checkout_date &&
            $VerifyHotel->total_price == $total_price &&
            $VerifyHotel->verify_code == $verify_code
        ) {
            // 如果匹配，则更新支付状态
            $VerifyHotel->payment_status = 1;
            $VerifyHotel->save();

            // 发送邮件到 ahpin7762@gmail.com
            Mail::to('ahpin7762@gmail.com')->send(new HotelPaymentVerification($VerifyHotel));

            // 返回之前的页面，并显示成功消息
            return redirect()->back()->with('success', 'Payment status updated successfully and verification information sent to your email.');
        } else {
            // 如果不匹配，则返回验证失败的信息
            return redirect()->back()->with('fail', 'Verify Fail, Information Verify Not Match.');
        }
    }

    public function checkoutHotel(Request $request, $bookingId)
    {
        try {
            DB::beginTransaction();

            // 获取预订信息
            $booking = BookingHotel::findOrFail($bookingId);
            $user = $booking->user;

            // 获取或创建用户钱包
            $userWallet = MyWallet::firstOrNew(['user_id' => $user->id]);

            // 获取Admin钱包并确保verify_code匹配
            $adminWallet = AdminWallet::where('verify_code', $booking->verify_code)->firstOrFail();

            // 将AdminWallet的balance转移到用户钱包的profit和balance
            $userWallet->profit += $adminWallet->balance;
            $userWallet->balance += $adminWallet->balance;
            $adminWallet->refund_user_balance = $adminWallet->balance;
            $adminWallet->balance = 0;
            $adminWallet->transferred_status = 1;

            // 将AdminWallet的user_deposit转移到用户钱包的refund_deposit
            $userWallet->refund_deposit += $adminWallet->user_deposit;
            $adminWallet->refund_user_deposit = $adminWallet->user_deposit;
            $adminWallet->user_deposit = 0;

            // 保存用户钱包和管理员钱包
            $userWallet->save();
            $adminWallet->save();

            // 更新预订状态
            $booking->payment_status = 2;
            $booking->save();

            DB::commit();

            return redirect()->back()->with('success', "Checked out successfully and deposit refunded!");

        } catch (\Exception $e) {

            DB::rollback();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    public function cancelBookingHotel(Request $request, $bookingId)
    {
        try {
            DB::beginTransaction();

            // 获取预订信息和用户信息
            $booking = BookingHotel::findOrFail($bookingId);
            $user = $booking->user;

            // 获取管理员钱包并确保verify_code匹配
            $adminWallet = AdminWallet::where('verify_code', $booking->verify_code)->firstOrFail();

            // 退款金额是预订价格的90%
            $refundAmount = $booking->total_price * 0.90;

            // 获取或创建用户钱包
            $userWallet = MyWallet::firstOrNew(['user_id' => $user->id]);

            // 更新用户钱包余额和退款金额
            $userWallet->balance += $refundAmount;
            $userWallet->refund_price += $refundAmount;
            $userWallet->save();

            // 更新管理员钱包余额和取消金额
            $adminWallet->balance -= $refundAmount;
            $adminWallet->user_cancel_balance += $refundAmount;
            $adminWallet->save();

            // 更新预订状态
            $booking->payment_status = 3;
            $booking->save();

            DB::commit();

            return redirect()->back()->with('success', "Booking cancelled and refund processed!");

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Cancellation failed: ' . $e->getMessage());
        }
    }

    public function mybookedHotel()
    {
        $user = auth()->user();

        // $restaurantIds = $user->restaurants()->pluck('id')->toArray();

        // Get the query builder instance before fetching results
        $hasBookedQuery = BookingHotel::whereIn('user_id', $user);

        // Paginate the query builder instance
        $mybookeds = $hasBookedQuery->paginate(10);

        // $bookedss = Restaurant::with('bookings', 'bookings.table')->get();

        return view('backend-user.mybooked.mybookedhotel', compact('mybookeds'));
    }

    public function processPaymentHotel($id, $room_id)
    {
        // Get the booking hotel record
        $hotel = BookingHotel::find($id);

        // Check if the record exists
        if (!$hotel) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Mark the hotel payment as 'Paid'
        $hotel->payment_status = 'Paid';
        $hotel->save();

        // Update the status of the related room
        $room = Room::find($room_id);

        if ($room) {
            $room->status = 0;
            $room->save();
        }

        // Retrieve the associated deposit using the relationship
        $deposit = $hotel->deposit;

        // Check if deposit record exists
        if ($deposit) {
            // Update the deposit status to '1' (assuming 'status' is a boolean field)
            $deposit->status = 1;
            $deposit->save();

        } else {

            return back()->with('error', 'Deposit record not found.');
        }

        // 发送电子邮件
        $data = [
            'subject' => 'You Booking Hotel Deposit Refund',
            'user_name' => $hotel->deposit->user_name,
            'email' => $hotel->deposit->user_email,
            'deposit_price' => $hotel->deposit->deposit_price,
            'hotel_name' => $hotel->hotel_name,
            'card_number' => $hotel->deposit->card_number,
            'card_holder' => $hotel->deposit->card_holder,
            'card_month' => $hotel->deposit->card_month,
            'card_year' => $hotel->deposit->card_year,
            'cvv' => $hotel->deposit->cvv,
        ];

        Mail::send('email.hoteldepositrefundemail', $data, function($message) use ($data) {
            $message->to('ahpin7762@gmail.com')
            ->subject($data['subject']);
        });

        // Redirect back with success message
        return redirect()->back()->with('success', 'Payment processed successfully.');
    }

    public function hasbookingHotel()
    {
        $user = auth()->user();

        // Get the hotel IDs booked by the user
        $hotelIds = $user->hotels()->pluck('id')->toArray();

        // Get the count of unpaid bookings for hotels
        $unpaidHotelBookingsCount = BookingHotel::whereIn('hotel_id', $hotelIds)
            ->where('payment_status', 'unpaid')
            ->count();

        // Get the paginated list of booked hotels
        $hotelbookeds = BookingHotel::whereIn('hotel_id', $hotelIds)->paginate(10);

        return view('backend-user.hasbooked.bookedhotel', compact('hotelbookeds', 'unpaidHotelBookingsCount'));
    }

    public function viewBookedHotel($id){

        $bookedhotels = BookingHotel::find($id);

        return view('backend-user.hasbooked.viewbookedhotel',compact('bookedhotels'));
    }

    public function hashotelSearch(Request $request)
    {
        $user = auth()->user();

        $hotelIds = $user->hotels()->pluck('id')->toArray();

        // Get the query builder instance before fetching results
        $hasBookedQuery = BookingHotel::whereIn('hotel_id', $hotelIds);

        // Paginate the query builder instance
        $bookeds = $hasBookedQuery->paginate(10);

        // Build your database query based on the input values
        $query = BookingHotel::query();

        if ($request->hotel_name) {
            $query->where('hotel_name', 'LIKE', '%' . $request->hotel_name . '%');
        }

        if ($request->user_name) {
            $query->where('user_name', 'LIKE', '%' . $request->user_name . '%');
        }

        if ($request->booking_date) {
            $query->whereDate('booking_date', '=', $request->booking_date);
        }

        if ($request->check_in_time && $request->check_out_time) {
            $query->where(function ($query) use ($request) {
                $query->where('checkin_time', '>=', $request->check_in_time)
                    ->where('checkout_time', '<=', $request->check_out_time);
            });
        }

        // Execute the query and retrieve the results
        $bookeds = $query->paginate(10);

        return view('backend-user.hasbooked.bookedhotel', compact('bookeds'));
    }

    public function deleteMultiplebookedhotel(Request $request)
    {
        $ids = json_decode($request->input('ids'));

        if (is_array($ids) && count($ids) > 0) {

            BookingHotel::whereIn('id', $ids)->delete();

            return back()->with('success', 'Selected Booked Hotels have been deleted successfully!');

        } else {

            return back()->with('error', 'Invalid input. No Booked Hotels were deleted.');
        }
    }

    // ----------------------------------------------- Verify Qr Code Booked Area---------------------------------------------------//
    public function verifyResort(Request $request, $resortId)
    {
        // Logic to verify the resort based on $resortId
        $bookedresorts = BookingResort::find($resortId);

        if ($bookedresorts) {
            // Resort verification successful
            return view('backend-user.verify.VerifyQrCodeResort', ['bookedresorts' => $bookedresorts]);
        } else {
            // Resort verification failed
            echo '<script>alert("Data Not Valid")</script>';
            return back()->withInput();
        }
    }

    public function verifyRestaurant(Request $request, $restaurantId)
    {
        // Logic to verify the Restaurant based on $restaurantId
        $bookedrestaurants = BookingRestaurant::find($restaurantId);

        if ($bookedrestaurants) {
            // Restaurant verification successful
            return view('backend-user.verify.verifyrestaurant', ['bookedrestaurants' => $bookedrestaurants]);
        } else {
            // Restaurant verification failed
            echo '<script>alert("Data Not Valid")</script>';
            return back()->withInput();
        }
    }


    public function verifyHotel(Request $request, $hotelId)
    {
        // Logic to verify the hotel based on $hotelId
        $bookedhotels = BookingHotel::find($hotelId);

        if ($bookedhotels) {
            // Hotel verification successful
            return view('backend-user.verify.verifyhotel', ['bookedhotels' => $bookedhotels]);
        } else {
            // Hotel verification failed
            echo '<script>alert("Data Not Valid")</script>';
            return back()->withInput();
        }
    }

}
