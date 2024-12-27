<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
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
use App\Models\ResortDiscount;
use App\Models\ResortExtendRecord;
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
use Illuminate\Support\Facades\Log;

use App\Services\PayPalService;
use PayPal\Api\Payment;
use Omnipay\Omnipay;
use DateTime;

class BookingController extends Controller
{

    //------------------------------------------------ Frontend Booking Restaurant Area --------------------------------------------------//
    // Special Full Code
    public function bookingrestaurantpage(Request $request, $id)
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

    public function bookingrestaurant(Request $request)
    {
        // 验证请求数据
        $validator = Validator::make($request->all(), [
            'booking_date' => 'required|date',
            'checkin_time' => 'required|date_format:H:i',
            'checkout_time' => 'required|date_format:H:i',
            'gender' => 'required',
            'quantity' => 'required|numeric|between:1,20',
            'payment_method' => 'required|in:credit_card,paypal',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        if (Auth::check()) {
            try {
                DB::beginTransaction();

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
                $payment->card_number = substr($request->card_number, -4) ?: '0000';
                $payment->card_holder = $request->card_holder ?: 'John Doe';
                $payment->card_month = $request->card_month ?: 1;
                $payment->card_year = $request->card_year ?: date('Y');
                $payment->cvv = Crypt::encryptString($request->cvv) ?: Crypt::encryptString('123');
                $payment->save();

                // Booking Restaurant save
                $bookings = new BookingRestaurant();
                $bookings->user_id = auth()->id();
                $bookings->user_name = $request->user()->name;
                $bookings->restaurant_id = $request->restaurant_id;
                $bookings->restaurant_name = $request->restaurant_name;
                $bookings->table_id = $request->table_id;
                $bookings->booking_date = $request->booking_date;
                $bookings->checkin_time = $request->checkin_time;
                $bookings->checkout_time = $request->checkout_time;
                $bookings->gender = $request->gender;
                $bookings->quantity = $request->quantity;
                $bookings->deposit_price = $deposit;
                $bookings->payment_method = $request->payment_method;
                $bookings->card_number = substr($request->card_number, -4) ?: '0000';
                $bookings->card_holder = $request->card_holder ?: 'John Doe';
                $bookings->card_month = $request->card_month ?: 1;
                $bookings->card_year = $request->card_year ?: date('Y');
                $bookings->cvv = Crypt::encryptString($request->cvv) ?: Crypt::encryptString('123');
                $bookings->verify_code = $verifyCode;
                $bookings->popular_count = 1;
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

                // 更新餐厅的 popular_count
                $restaurant = Restaurant::find($request->restaurant_id);
                if ($restaurant) {
                    $restaurant->increment('popular_count');
                }

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

                Mail::send('email.restaurantemail', $data, function ($message) use ($data) {
                    $message->to('ahpin7762@gmail.com')->subject($data['subject']);
                });

                DB::commit();

                event(new BookingStatus());

                return response()->json(['success' => true, 'message' => "Restaurant {$bookings->restaurant_name} Booking successfully!"]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['success' => false, 'message' => 'Booking failed: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'You need to log in first.'], 401);
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
        // 确保用户已认证
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You need to log in to view your bookings.');
        }

        // 获取当前认证用户的 ID
        $userId = auth()->id();

        // 获取预订记录
        $mybookeds = BookingRestaurant::where('user_id', $userId)->paginate(10);

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

        $VerifyRestaurant = BookingRestaurant::find($id);

        return view('backend-user.hasbooked.viewbookedrestaurant',compact('VerifyRestaurant'));
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

    // Full Data Resort Page
    public function bookingresortpage(Request $request, $id)
    {
        if (Auth::check()) {
            // 获取基础数据
            $genders = Gender::all();
            $resorts = Resort::find($id);

            // 获取已预订的日期范围
            $bookedDates = $this->getBookedResortDates($id);

            // 获取促销日期和价格
            $promotionDatesWithPrices = $resorts->getPromotionDatesWithPrices();

            // 获取度假村的折扣政策，按住宿天数降序排序
            $discounts = ResortDiscount::where('resort_id', $id)
                ->orderBy('nights', 'desc')
                ->get();

            // 将促销日期和价格数组转换为对象数组
            $promotionDatesWithPricesObject = [];
            foreach ($promotionDatesWithPrices as $date => $price) {
                $promotionDatesWithPricesObject[] = [
                    'date' => $date,
                    'price' => $price // 价格已经是浮点数了
                ];
            }

            return view('frontend-auth.frontend-resort.bookingresort', compact(
                'resorts',
                'genders',
                'bookedDates',
                'promotionDatesWithPricesObject',
                'discounts'
            ));
        } else {
            return redirect()
                ->route('frontend-auth.login')
                ->with('error', 'You need to log in first.');
        }
    }

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

    // public function bookingresort(Request $request)
    // {
    //     // 验证请求数据
    //     $validator = Validator::make($request->all(), [
    //         'checkin_date' => 'required|date',
    //         'checkout_date' => 'required|date|after_or_equal:checkin_date',
    //         'checkin_time' => 'required|date_format:H:i',
    //         'checkout_time' => 'required|date_format:H:i',
    //         'gender' => 'required',
    //         'quantity' => 'required|numeric|between:1,20',
    //         'payment_method' => 'required|in:credit_card,paypal',
    //         // 'total_price' => 'required|numeric|min:0', // 添加对 total_price 的验证
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
    //     }

    //     if (Auth::check()) {
    //         try {
    //             DB::beginTransaction();

    //             $checkinDate = Carbon::parse($request->checkin_date);
    //             $checkoutDate = Carbon::parse($request->checkout_date);
    //             $bookingDays = $checkoutDate->diffInDays($checkinDate);

    //             // 直接使用前端传来的total_price
    //             $totalPrice = $request->total_price ?? 0;

    //             $tax = $totalPrice * 0.10;
    //             $deposit = $request->deposit_price;
    //             $balance = $totalPrice - $tax;

    //             $verifyCode = Str::random(10);

    //             // Save Deposit Information
    //             $payment = new Deposit();
    //             $payment->user_name = $request->user()->name;
    //             $payment->user_email = $request->user()->email;
    //             $payment->type_name = $request->type_name;
    //             $payment->deposit_price = $deposit;
    //             $payment->total_price = $totalPrice;
    //             $payment->card_number = substr($request->card_number, -4) ?: '0000';
    //             $payment->card_holder = $request->card_holder ?: 'John Doe';
    //             $payment->card_month = $request->card_month ?: 1;
    //             $payment->card_year = $request->card_year ?: date('Y');
    //             $payment->cvv = Crypt::encryptString($request->cvv) ?: Crypt::encryptString('123');
    //             $payment->save();

    //             // Save Booking Resort Information
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
    //             $booking->deposit_price = $deposit;
    //             $booking->total_price = $totalPrice;
    //             $booking->payment_method = $request->payment_method;
    //             $booking->card_number = substr($request->card_number, -4) ?: '0000';
    //             $booking->card_holder = $request->card_holder ?: 'John Doe';
    //             $booking->card_month = $request->card_month ?: 1;
    //             $booking->card_year = $request->card_year ?: date('Y');
    //             $booking->cvv = Crypt::encryptString($request->cvv) ?: Crypt::encryptString('123');
    //             $booking->verify_code = $verifyCode;
    //             // $booking->booking_uuid = $request->booking_uuid; // 添加 UUID
    //             $booking->popular_count = 1;
    //             $booking->save();

    //             // 更新管理员钱包
    //             $adminWallet = new AdminWallet();
    //             $adminWallet->type_id = $request->type_id;
    //             $adminWallet->type_name = $request->type_name;
    //             $adminWallet->type_category = $request->type_category;
    //             $adminWallet->balance = $balance;
    //             $adminWallet->user_deposit = $deposit;
    //             $adminWallet->tax = $tax;
    //             $adminWallet->verify_code = $verifyCode;
    //             $adminWallet->save();

    //             // 更新餐厅的 popular_count
    //             $resort = Resort::find($request->resort_id);
    //             if ($resort) {
    //                 $resort->increment('popular_count');
    //             }

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
    //                 'total_price' => $totalPrice,
    //                 'resort_type' => $request->resort_type,
    //             ];

    //             Mail::send('email.resortemail', $data, function ($message) use ($data) {
    //                 $message->to($data['email'])->subject($data['subject']);
    //             });

    //             DB::commit();

    //             event(new BookingStatus());

    //             return response()->json(['success' => true, 'message' => "Resort {$booking->resort_name} booked successfully!"]);
    //         } catch (\Exception $e) {
    //             DB::rollback();
    //             return response()->json(['success' => false, 'message' => 'Booking failed: ' . $e->getMessage()], 500);
    //         }
    //     } else {
    //         return response()->json(['success' => false, 'message' => 'You need to log in first.'], 401);
    //     }
    // }

    public function bookingresort(Request $request)
    {
        // 验证请求数据
        $validator = Validator::make($request->all(), [
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after_or_equal:checkin_date',
            'checkin_time' => 'required|date_format:H:i',
            'checkout_time' => 'required|date_format:H:i',
            'gender' => 'required',
            'quantity' => 'required|numeric|between:1,20',
            'payment_method' => 'required|in:credit_card,paypal',
            // 'booking_uuid' => 'required|uuid', // 添加对 booking_uuid 的验证
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        if (Auth::check()) {
            try {
                DB::beginTransaction();

                // 检查是否已经存在相同的UUID
                // $existingBooking = BookingResort::where('booking_uuid', $request->booking_uuid)->first();
                // if ($existingBooking) {
                //     return response()->json(['success' => false, 'message' => 'Duplicate booking detected.'], 409);
                // }

                $checkinDate = Carbon::parse($request->checkin_date);
                $checkoutDate = Carbon::parse($request->checkout_date);
                $bookingDays = $checkoutDate->diffInDays($checkinDate);

                // 直接使用前端传来的total_price
                $totalPrice = $request->total_price ?? 0;

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
                $payment->payment_method = $request->payment_method;
                $payment->card_number = substr($request->card_number, -4) ?: '0000';
                $payment->card_holder = $request->card_holder ?: 'John Doe';
                $payment->card_month = $request->card_month ?: 1;
                $payment->card_year = $request->card_year ?: date('Y');
                $payment->cvv = Crypt::encryptString($request->cvv) ?: Crypt::encryptString('123');
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
                $booking->payment_method = $request->payment_method;
                $booking->card_number = substr($request->card_number, -4) ?: '0000';
                $booking->card_holder = $request->card_holder ?: 'John Doe';
                $booking->card_month = $request->card_month ?: 1;
                $booking->card_year = $request->card_year ?: date('Y');
                $booking->cvv = Crypt::encryptString($request->cvv) ?: Crypt::encryptString('123');
                $booking->verify_code = $verifyCode;
                // $booking->booking_uuid = $request->booking_uuid; // 添加 UUID
                $booking->popular_count = 1;
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

                // 更新餐厅的 popular_count
                $resort = Resort::find($request->resort_id);
                if ($resort) {
                    $resort->increment('popular_count');
                }

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

                return response()->json(['success' => true, 'message' => "Resort {$booking->resort_name} booked successfully!"]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['success' => false, 'message' => 'Booking failed: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'You need to log in first.'], 401);
        }
    }

    public function paypalSuccess(Request $request)
    {
        $paypalService = new PayPalService();
        $paymentId = $request->get('paymentId');
        $payerId = $request->get('PayerID');

        $result = $paypalService->executePayment($paymentId, $payerId);

        if ($result) {
            return redirect()->route('home')->with('success', 'Payment successful!');
        } else {
            return redirect()->route('home')->with('error', 'Payment failed!');
        }
    }

    public function paypalCancel()
    {
        return redirect()->route('home')->with('error', 'Payment cancelled!');
    }

    // ----------------------------------------------------------- Verify Area ------------------------------------------------------ //

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
        // 确保用户已认证
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You need to log in to view your bookings.');
        }

        // 获取当前认证用户的 ID
        $userId = auth()->id();

        // 获取预订记录
        $mybookeds = BookingResort::where('user_id', $userId)->paginate(10);

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

        $VerifyResort = BookingResort::find($id);

        return view('backend-user.hasbooked.viewbookedresort',compact('VerifyResort'));
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

    // New With Paypal
    public function bookinghotel(Request $request)
    {
        // 验证请求数据
        $validator = Validator::make($request->all(), [
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after_or_equal:checkin_date',
            'checkin_time' => 'required|date_format:H:i',
            'checkout_time' => 'required|date_format:H:i',
            'gender' => 'required',
            'quantity' => 'required|numeric|between:1,20',
            'payment_method' => 'required|in:credit_card,paypal',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        if (Auth::check()) {
            try {
                DB::beginTransaction();

                $checkinDate = Carbon::parse($request->checkin_date);
                $checkoutDate = Carbon::parse($request->checkout_date);
                $bookingDays = $checkoutDate->diffInDays($checkinDate);

                $totalPrice = $request->room_price * $bookingDays;

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
                $payment->card_number = substr($request->card_number, -4) ?: '0000';
                $payment->card_holder = $request->card_holder ?: 'John Doe';
                $payment->card_month = $request->card_month ?: 1;
                $payment->card_year = $request->card_year ?: date('Y');
                $payment->cvv = Crypt::encryptString($request->cvv) ?: Crypt::encryptString('123');
                $payment->save();

                // Save Booking Hotel Information
                $booking = new BookingHotel();
                $booking->user_id = auth()->id();
                $booking->user_name = $request->user()->name;
                $booking->hotel_id = $request->hotel_id;
                $booking->hotel_name = $request->hotel_name;
                $booking->room_id = $request->room_id;
                $booking->gender = $request->gender;
                $booking->quantity = $request->quantity;
                $booking->checkin_date = $request->checkin_date;
                $booking->checkout_date = $request->checkout_date;
                $booking->booking_days = $bookingDays;
                $booking->checkin_time = $request->checkin_time;
                $booking->checkout_time = $request->checkout_time;
                $booking->deposit_price = $deposit;
                $booking->total_price = $totalPrice;
                $booking->payment_method = $request->payment_method;
                $booking->card_number = substr($request->card_number, -4) ?: '0000';
                $booking->card_holder = $request->card_holder ?: 'John Doe';
                $booking->card_month = $request->card_month ?: 1;
                $booking->card_year = $request->card_year ?: date('Y');
                $booking->cvv = Crypt::encryptString($request->cvv) ?: Crypt::encryptString('123');
                $booking->verify_code = $verifyCode;
                $booking->popular_count = 1;
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

                // 更新酒店的 popular_count
                $hotel = Hotel::find($request->hotel_id);
                if ($hotel) {
                    $hotel->increment('popular_count');
                }

                DB::commit();

                event(new BookingStatus());

                return response()->json(['success' => true, 'message' => "Hotel {$booking->hotel_name} booked successfully!"]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['success' => false, 'message' => 'Booking failed: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'You need to log in first.'], 401);
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
        // 确保用户已认证
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You need to log in to view your bookings.');
        }

        // 获取当前认证用户的 ID
        $userId = auth()->id();

        // 获取预订记录
        $mybookeds = BookingHotel::where('user_id', $userId)->paginate(10);

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

        $VerifyHotel = BookingHotel::find($id);

        return view('backend-user.hasbooked.viewbookedhotel',compact('VerifyHotel'));
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
        $bookedResort = BookingResort::with('resort', 'user')->find($resortId);

        if (!$bookedResort) {
            return back()->withInput()->with('error', 'Data Not Valid');
        }

        // 获取从请求中传递过来的验证信息
        $user_id = $request->query('user_id');
        $resort_id = $request->query('resort_id');
        $checkin_date = $request->query('checkin_date');
        $checkout_date = $request->query('checkout_date');
        $checkin_time = $request->query('checkin_time');
        $checkout_time = $request->query('checkout_time');
        $total_price = $request->query('total_price');
        $verify_code = $request->query('verify_code');

        // 获取当前马来西亚的日期和时间
        $currentDateTime = now('Asia/Kuala_Lumpur');

        // 组合 checkin 和 checkout 的日期和时间
        $checkinDateTime = Carbon::parse($bookedResort->checkin_date . ' ' . $bookedResort->checkin_time, 'Asia/Kuala_Lumpur');
        $checkoutDateTime = Carbon::parse($bookedResort->checkout_date . ' ' . $bookedResort->checkout_time, 'Asia/Kuala_Lumpur');

        // 检查是否超过 checkin 日期和时间
        if ($currentDateTime->lt($checkinDateTime)) {
            return back()->withInput()->with('error', 'Check-in time has not yet arrived');
        }

        // 检查是否在 checkout 日期和时间之前
        if ($currentDateTime->gt($checkoutDateTime)) {
            return back()->withInput()->with('error', 'Check-out time has passed');
        }

        // 验证信息是否匹配
        if (
            $bookedResort->user_id == $user_id &&
            $bookedResort->resort_id == $resort_id &&
            $bookedResort->checkin_date == $checkin_date &&
            $bookedResort->checkout_date == $checkout_date &&
            $bookedResort->checkin_time == $checkin_time &&
            $bookedResort->checkout_time == $checkout_time &&
            $bookedResort->total_price == $total_price &&
            $bookedResort->verify_code == $verify_code
        ) {
            // 如果匹配，则更新支付状态
            $bookedResort->payment_status = 1;
            $bookedResort->save();

            // 发送邮件到 ahpin7762@gmail.com
            Mail::to('ahpin7762@gmail.com')->send(new ResortPaymentVerification($bookedResort));

            // 返回之前的页面，并显示成功消息
            return redirect('http://192.168.119.154:8000/mybookingsresort')->with('success', 'Payment status updated successfully and verification information sent to your email.');
        } else {
            // 如果不匹配，则返回验证失败的信息
            return redirect()->back()->with('fail', 'Verify Fail, Information Verify Not Match.');
        }
    }

    public function verifyHotel(Request $request, $hotelId)
    {
        $bookedHotel = BookingHotel::with('hotel', 'user')->find($hotelId);

        if (!$bookedHotel) {
            return back()->withInput()->with('error', 'Data Not Valid');
        }

        // 获取从请求中传递过来的验证信息
        $user_id = $request->query('user_id');
        $hotel_id = $request->query('hotel_id');
        $checkin_date = $request->query('checkin_date');
        $checkout_date = $request->query('checkout_date');
        $checkin_time = $request->query('checkin_time');
        $checkout_time = $request->query('checkout_time');
        $total_price = $request->query('total_price');
        $verify_code = $request->query('verify_code');

        // 获取当前马来西亚的日期和时间
        $currentDateTime = now('Asia/Kuala_Lumpur');

        // 组合 checkin 和 checkout 的日期和时间
        $checkinDateTime = Carbon::parse($bookedHotel->checkin_date . ' ' . $bookedHotel->checkin_time, 'Asia/Kuala_Lumpur');
        $checkoutDateTime = Carbon::parse($bookedHotel->checkout_date . ' ' . $bookedHotel->checkout_time, 'Asia/Kuala_Lumpur');

        // 检查是否超过 checkin 日期和时间
        if ($currentDateTime->lt($checkinDateTime)) {
            return back()->withInput()->with('error', 'Check-in time has not yet arrived');
        }

        // 检查是否在 checkout 日期和时间之前
        if ($currentDateTime->gt($checkoutDateTime)) {
            return back()->withInput()->with('error', 'Check-out time has passed');
        }

        // 验证信息是否匹配
        if (
            $bookedHotel->user_id == $user_id &&
            $bookedHotel->hotel_id == $hotel_id &&
            $bookedHotel->checkin_date == $checkin_date &&
            $bookedHotel->checkout_date == $checkout_date &&
            $bookedHotel->checkin_time == $checkin_time &&
            $bookedHotel->checkout_time == $checkout_time &&
            $bookedHotel->total_price == $total_price &&
            $bookedHotel->verify_code == $verify_code
        ) {
            // 如果匹配，则更新支付状态
            $bookedHotel->payment_status = 1;
            $bookedHotel->save();

            // 发送邮件到 ahpin7762@gmail.com
            Mail::to('ahpin7762@gmail.com')->send(new HotelPaymentVerification($bookedHotel));

            // 返回之前的页面，并显示成功消息
            return redirect('http://192.168.111.154:8000/mybookingshotel')->with('success', 'Payment status updated successfully and verification information sent to your email.');
        } else {
            // 如果不匹配，则返回验证失败的信息
            return redirect()->back()->with('fail', 'Verify Fail, Information Verify Not Match.');
        }
    }

    public function verifyRestaurant(Request $request, $restaurantId)
    {
        $bookedRestaurant = BookingRestaurant::with('restaurant', 'user')->find($restaurantId);

        if (!$bookedRestaurant) {
            return back()->withInput()->with('error', 'Data Not Valid');
        }

        // 获取从请求中传递过来的验证信息
        $user_id = $request->query('user_id');
        $restaurant_id = $request->query('restaurant_id');
        $booking_date = $request->query('booking_date');
        $checkin_time = $request->query('checkin_time');
        $checkout_time = $request->query('checkout_time');
        $total_price = $request->query('total_price');
        $verify_code = $request->query('verify_code');

        // 获取当前马来西亚的日期和时间
        $currentDateTime = now('Asia/Kuala_Lumpur');

        // 组合 checkin 和 checkout 的日期和时间
        $checkinDateTime = Carbon::parse($bookedRestaurant->booking_date . ' ' . $bookedRestaurant->checkin_time, 'Asia/Kuala_Lumpur');
        $checkoutDateTime = Carbon::parse($bookedRestaurant->booking_date . ' ' . $bookedRestaurant->checkout_time, 'Asia/Kuala_Lumpur');

        // 检查是否超过 checkin 日期和时间
        if ($currentDateTime->lt($checkinDateTime)) {
            return back()->withInput()->with('error', 'Check-in time has not yet arrived');
        }

        // 检查是否在 checkout 日期和时间之前
        if ($currentDateTime->gt($checkoutDateTime)) {
            return back()->withInput()->with('error', 'Check-out time has passed');
        }

        // 验证信息是否匹配
        if (
            $bookedRestaurant->user_id == $user_id &&
            $bookedRestaurant->restaurant_id == $restaurant_id &&
            $bookedRestaurant->booking_date == $booking_date &&
            $bookedRestaurant->checkin_time == $checkin_time &&
            $bookedRestaurant->checkout_time == $checkout_time &&
            $bookedRestaurant->total_price == $total_price &&
            $bookedRestaurant->verify_code == $verify_code
        ) {
            // 如果匹配，则更新支付状态
            $bookedRestaurant->payment_status = 1;
            $bookedRestaurant->save();

            // 发送邮件到 ahpin7762@gmail.com
            Mail::to('ahpin7762@gmail.com')->send(new RestaurantPaymentVerification($bookedRestaurant));

            // 返回之前的页面，并显示成功消息
            return redirect('http://192.168.111.154:8000/mybookingsrestaurant')->with('success', 'Payment status updated successfully and verification information sent to your email.');
        } else {
            // 如果不匹配，则返回验证失败的信息
            return redirect()->back()->with('fail', 'Verify Fail, Information Verify Not Match.');
        }
    }

    public function ExtandorCancelResort($id)
    {
        // 获取度假村预订的详情
        $bookingResort = BookingResort::findOrFail($id);

        // 计算预订日期
        $bookingDates = [];
        $currentDate = new DateTime($bookingResort->checkin_date);
        $checkoutDate = new DateTime($bookingResort->checkout_date);

        // 包括 checkout_date
        while ($currentDate <= $checkoutDate) {
            $bookingDates[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
        }

        // 获取特定度假村的所有预订记录
        $resortBookings = BookingResort::where('resort_id', $bookingResort->resort_id)->get();
        $allBookingDates = [];

        foreach ($resortBookings as $booking) {
            $currentDate = new DateTime($booking->checkin_date);
            $checkoutDate = new DateTime($booking->checkout_date);

            while ($currentDate <= $checkoutDate) {
                $allBookingDates[] = $currentDate->format('Y-m-d');
                $currentDate->modify('+1 day');
            }
        }

        // 将度假村信息和预订日期传递给视图
        return view('backend-user.mybooked.mybookedresortextandorcancel', compact('bookingResort', 'bookingDates', 'allBookingDates'));
    }

    public function extendBooking(Request $request, $id)
    {
        // 获取度假村预订的详情
        $bookingResort = BookingResort::findOrFail($id);

        // 获取延长的日期
        $extendDates = $request->input('extend_dates');

        // 将逗号分隔的字符串转换为数组
        $extendDatesArray = explode(',', $extendDates);

        // 计算新的 checkout_date
        $currentCheckoutDate = new DateTime($bookingResort->checkout_date);
        foreach ($extendDatesArray as $date) {
            $extendDate = new DateTime($date);
            if ($extendDate > $currentCheckoutDate) {
                $currentCheckoutDate = $extendDate;
            }
        }
        // $currentCheckoutDate->modify('+1 day');

        // 更新 BookingResort 的 checkout_date
        $bookingResort->checkout_date = $currentCheckoutDate->format('Y-m-d');
        $bookingResort->save();

        // 记录延长信息到 ResortExtendRecord
        $extendRecord = new ResortExtendRecord();
        $extendRecord->booking_resort_id = $bookingResort->id;
        $extendRecord->checkin_date = $bookingResort->checkin_date;
        $extendRecord->checkout_date = $currentCheckoutDate->format('Y-m-d');
        $extendRecord->extend_dates = json_encode($extendDatesArray);
        $extendRecord->payment_information = $request->input('payment_information');
        $extendRecord->save();

        return back()->with('success', 'Booking extended successfully.');
    }

    public function cancelBookingDate(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // 找到预订记录
            $bookingResort = BookingResort::findOrFail($id);

            // 获取要取消的日期并处理格式
            $selectedDates = json_decode($request->input('selected_dates'), true);

            // 处理日期格式，移除星期几信息
            $selectedDates = array_map(function($date) {
                return substr($date, 0, 10); // 只保留 YYYY-MM-DD 部分
            }, $selectedDates);

            // 验证日期格式
            if (!is_array($selectedDates)) {
                return redirect()->back()->with('error', 'Invalid selected dates format.');
            }

            // 记录调试信息
            Log::info('Selected dates to cancel:', $selectedDates);
            Log::info('Original booking:', [
                'checkin' => $bookingResort->checkin_date,
                'checkout' => $bookingResort->checkout_date
            ]);

            // 获取所有预订日期
            $allBookingDates = [];
            $currentDate = new DateTime($bookingResort->checkin_date);
            $checkoutDate = new DateTime($bookingResort->checkout_date);

            while ($currentDate <= $checkoutDate) {
                $allBookingDates[] = $currentDate->format('Y-m-d');
                $currentDate->modify('+1 day');
            }

            Log::info('All booking dates:', $allBookingDates);

            // 移除要取消的日期
            $remainingDates = array_values(array_diff($allBookingDates, $selectedDates));

            Log::info('Remaining dates after cancellation:', $remainingDates);

            // 计算取消日期的总价格
            $totalPrice = count($selectedDates) * $bookingResort->resort->price;

            // 如果没有剩余日期，删除整个预订
            if (empty($remainingDates)) {
                // 更新管理员钱包
                $adminWallet = AdminWallet::where('verify_code', $bookingResort->verify_code)->first();
                if ($adminWallet) {
                    $adminWallet->balance -= $totalPrice;
                    $adminWallet->save();
                }

                // 删除预订
                $bookingResort->delete();

                DB::commit();
                return redirect()->back()->with('success', 'All booking dates canceled successfully.');
            }

            // 更新预订日期
            $newCheckinDate = min($remainingDates);
            $newCheckoutDate = max($remainingDates);

            Log::info('New dates:', [
                'checkin' => $newCheckinDate,
                'checkout' => $newCheckoutDate
            ]);

            // 直接使用查询更新，确保数据被更新
            $updated = DB::table('booking_resorts')
                ->where('id', $bookingResort->id)
                ->update([
                    'checkin_date' => $newCheckinDate,
                    'checkout_date' => $newCheckoutDate
                ]);

            Log::info('Update result:', ['updated' => $updated]);

            // 更新管理员钱包
            $adminWallet = AdminWallet::where('verify_code', $bookingResort->verify_code)->first();
            if (!$adminWallet) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Admin wallet not found for the given verify_code.');
            }

            $adminWallet->balance -= $totalPrice;
            $adminWallet->save();

            // 验证更新是否成功
            $updatedBooking = BookingResort::find($id);
            Log::info('Final booking state:', [
                'checkin' => $updatedBooking->checkin_date,
                'checkout' => $updatedBooking->checkout_date
            ]);

            DB::commit();

            if ($updated) {
                return redirect()->back()->with('success', 'Booking dates canceled successfully.');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to update booking dates.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in cancelBookingDate:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'An error occurred while canceling booking dates: ' . $e->getMessage());
        }
    }

}
