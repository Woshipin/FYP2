<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingRestaurant;
use App\Models\BookingResort;
use App\Models\BookingHotel;
use App\Models\User;
use App\Models\Contact;
use App\Models\Comment;
use App\Models\Restaurant;
use App\Models\Resort;
use App\Models\Hotel;
use App\Models\MyWallet;
use App\Models\AdminWallet;
use App\Models\FaceRecognition;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\FaceRecognitionService;
use Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use App\Services\RecommendationService;

class UserController extends Controller
{

    public function showLoginPage(){

        return view('frontend-auth.auth');
    }

    public function loadRegister(){

        return view('frontend-auth.register');
    }

    public function loadLogin()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->status == 0) {
                // 用户未验证邮箱，重定向到登录页面
                Auth::logout();
                return redirect('/login')->with('fail', "Your account is not verified. Please verify your email first.");
            }

            // 用户已验证邮箱，重定向到主页或其他页面
            return redirect('/')->with('success', "You are logged in successfully!");
        }

        return view('frontend-auth.login');
    }

    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $errors = ['fail' => "User email or password is incorrect."];
            return back()->withInput()->withErrors($errors);
        }

        // if ($user->status == 0) {
        //     return back()->withInput()->with('fail', "Your account is not verified. Please verify your email first.");
        // }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/')->with('success', "You are logged in successfully!");
        } else {
            $errors = ['fail' => "User email or password is incorrect."];
            return back()->withInput()->withErrors($errors);
        }
    }

    // Checked box remmeber function
    protected function authenticated(Request $request, $user)
    {
        if ($request->has('remember')) {
            $remember = true; // 如果用户勾选了记住我，设置为true
        } else {
            $remember = false;
        }

        return redirect()->intended($this->redirectTo);
    }

    public function userregister(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:1',
            'email' => 'string|required|email|max:100|unique:users,email',
            'password' => 'string|required|min:6|max:12',
            'password_confirmation' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // 创建用户
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            // 不再使用 Hash::make() 对密码进行哈希处理
            $user->password = $request->password;
            $user->status = 0; // 设置用户状态为未激活
            $user->save();

            // 创建用户钱包记录
            $wallet = new MyWallet;
            $wallet->user_id = $user->id;
            $wallet->user_name = $user->name;
            $wallet->profit = 0;
            $wallet->balance = 0;
            $wallet->refund_price = 0;
            $wallet->refund_deposit = 0;
            $wallet->save();

            // 发送验证邮件
            $this->sendVerificationEmail($user);

            return back()->with('success', 'A verification link has been sent to your email. Please verify your email address to complete the registration.');

        } catch (\Exception $e) {
            return back()->with('fail', 'Failed to register. Please try again.');
        }
    }

    private function sendVerificationEmail($user)
    {
        $verificationCode = Str::random(40); // 生成一个随机的验证码
        $user->verification_code = $verificationCode;
        $user->save();

        $verificationLink = route('verify.email', ['code' => $verificationCode]);

        $data = [
            'verificationLink' => $verificationLink
        ];

        Mail::send('email.emailsverify', $data, function ($message) use ($user) {
            $message->to($user->email)->subject('Verify Your Email Address');
        });
    }

    // 验证邮箱
    public function verifyEmail($code)
    {
        $user = User::where('verification_code', $code)->first();

        if (!$user) {
            return back()->with('fail', 'Invalid verification code.');
        }

        // 激活用户
        $user->status = 1;
        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->save();

        return redirect('/login')->with('success', 'Your email has been verified. You can now login.');
    }

    protected $recommendationController;

    public function __construct(RecommendationController $recommendationController)
    {
        $this->recommendationController = $recommendationController;
    }

    public function home() {

        $resorts = Resort::where('register_status', 1)
                    ->orderBy('popular_count', 'desc')
                    ->take(6)
                    ->get();

        $restaurants = Restaurant::where('register_status', 1)
                    ->orderBy('popular_count', 'desc')
                    ->take(6)
                    ->get();

        $hotels = Hotel::where('register_status', 1)
                    ->orderBy('popular_count', 'desc')
                    ->take(6)
                    ->get();

        $comments = Comment::all();

        $resortRatings = [];

        foreach ($resorts as $resort) {
            // 省略获取度假村评分的逻辑
        }

        $hotelRatings = [];

        foreach ($hotels as $hotel) {
            // 省略获取酒店评分的逻辑
        }

        $restaurantRatings = [];

        foreach ($restaurants as $restaurant) {
            // 省略获取餐厅评分的逻辑
        }

        // 如果用户已登录，获取推荐数据
        $recommendations = [];
        if (auth()->check()) {
            // 实例化 RecommendationService
            $recommendationService = new RecommendationService();

            // 获取推荐数据
            $recommendations = $recommendationService->getRecommendations(auth()->user()->id);
        }

        return view('frontend-auth.newhome', compact('resorts', 'restaurants', 'hotels', 'comments', 'resortRatings','hotelRatings', 'restaurantRatings', 'recommendations'));
    }

    public function logout(Request $request){

        $request->session()->flush();
        Auth::logout();
        return redirect('/login')->with('fail', "You are Logout Successfully!");
    }

    // public function userdashboard()
    // {
    //     if (Auth::check()) {
    //         $userId = auth()->id(); // Get the authenticated user's ID

    //         // User Restaurant Area Chart
    //         $bookingRestaurants = BookingRestaurant::select('created_at')
    //             ->where('user_id', $userId)
    //             ->orderBy('created_at')
    //             ->get();

    //         $restaurantLabels = [];
    //         $restaurantData = [];

    //         foreach ($bookingRestaurants as $bookingRestaurant) {
    //             $restaurantLabels[] = $bookingRestaurant['created_at']->format('Y-m-d');
    //         }

    //         $restaurantPopularCounts = Restaurant::select('name', 'popular_count')
    //             ->where('user_id', $userId)
    //             ->where('popular_count', '>', 0)
    //             ->orderBy('name')
    //             ->get();

    //         foreach ($restaurantPopularCounts as $restaurant) {
    //             $restaurantData[] = [
    //                 'name' => $restaurant['name'],
    //                 'popular_count' => $restaurant['popular_count']
    //             ];
    //         }

    //         // User Resort Area Chart
    //         $bookingResorts = BookingResort::select('created_at')
    //             ->where('user_id', $userId)
    //             ->orderBy('created_at')
    //             ->get();

    //         $resortLabels = [];
    //         $resortData = [];

    //         foreach ($bookingResorts as $bookingResort) {
    //             $resortLabels[] = $bookingResort['created_at']->format('Y-m-d');
    //         }

    //         $resortPopularCounts = Resort::select('name', 'popular_count')
    //             ->where('user_id', $userId)
    //             ->where('popular_count', '>', 0)
    //             ->orderBy('name')
    //             ->get();

    //         foreach ($resortPopularCounts as $resort) {
    //             $resortData[] = [
    //                 'name' => $resort['name'],
    //                 'popular_count' => $resort['popular_count']
    //             ];
    //         }

    //         // User Hotel Area Chart
    //         $bookingHotels = BookingHotel::select('created_at')
    //             ->where('user_id', $userId)
    //             ->orderBy('created_at')
    //             ->get();

    //         $hotelLabels = [];
    //         $hotelData = [];

    //         foreach ($bookingHotels as $bookingHotel) {
    //             $hotelLabels[] = $bookingHotel['created_at']->format('Y-m-d');
    //         }

    //         $hotelPopularCounts = Hotel::select('name', 'popular_count')
    //             ->where('user_id', $userId)
    //             ->where('popular_count', '>', 0)
    //             ->orderBy('name')
    //             ->get();

    //         foreach ($hotelPopularCounts as $hotel) {
    //             $hotelData[] = [
    //                 'name' => $hotel['name'],
    //                 'popular_count' => $hotel['popular_count']
    //             ];
    //         }

    //         // All Booked Pie Chart
    //         // 收集已预订的餐厅、度假村和酒店的总预订数
    //         $bookedRestaurants = BookingRestaurant::where('user_id', $userId)->count();
    //         $bookedResorts = BookingResort::where('user_id', $userId)->count();
    //         $bookedHotels = BookingHotel::where('user_id', $userId)->count();

    //         $labels = ['Restaurants', 'Resorts', 'Hotels'];
    //         $data = [$bookedRestaurants, $bookedResorts, $bookedHotels];

    //         // Get Booked Restaurant with auth id
    //         $todayDate = Carbon::now()->format('Y-m-d');
    //         $todayMonth = Carbon::now()->format('m');
    //         $todayYear = Carbon::now()->format('Y');

    //         // All Restaurant Resort and Hotel count with auth id
    //         $bookedRestaurant = Restaurant::where('user_id', $userId)->count();
    //         $bookedResort = Resort::where('user_id', $userId)->count();
    //         $bookedHotel = Hotel::where('user_id', $userId)->count();

    //         // Resort bookings for today for the user
    //         $todaybookedresort = BookingResort::where('user_id', $userId)
    //             ->whereDate('created_at', $todayDate)
    //             ->count();

    //         // Resort bookings for the current month for the user
    //         $thisMonthbookedresort = BookingResort::where('user_id', $userId)
    //             ->whereMonth('created_at', $todayMonth)
    //             ->count();

    //         // Resort bookings for the current year for the user
    //         $thisYearbookedresort = BookingResort::where('user_id', $userId)
    //             ->whereYear('created_at', $todayYear)
    //             ->count();

    //         // Restaurant bookings for today for the user
    //         $todaybookedrestaurant = BookingRestaurant::where('user_id', $userId)
    //             ->whereDate('created_at', $todayDate)
    //             ->count();

    //         // Restaurant bookings for the current month for the user
    //         $thisMonthbookedrestaurant = BookingRestaurant::where('user_id', $userId)
    //             ->whereMonth('created_at', $todayMonth)
    //             ->count();

    //         // Restaurant bookings for the current year for the user
    //         $thisYearbookedrestaurant = BookingRestaurant::where('user_id', $userId)
    //             ->whereYear('created_at', $todayYear)
    //             ->count();

    //         // Hotel bookings for today for the user
    //         $todaybookedhotel = BookingHotel::where('user_id', $userId)
    //             ->whereDate('created_at', $todayDate)
    //             ->count();

    //         // Hotel bookings for the current month for the user
    //         $thisMonthbookedhotel = BookingHotel::where('user_id', $userId)
    //             ->whereMonth('created_at', $todayMonth)
    //             ->count();

    //         // Hotel bookings for the current year for the user
    //         $thisYearbookedhotel = BookingHotel::where('user_id', $userId)
    //             ->whereYear('created_at', $todayYear)
    //             ->count();

    //         return view('backend-user.newdashboard', compact(
    //             'restaurantLabels', 'restaurantData',
    //             'resortLabels', 'resortData',
    //             'hotelLabels', 'hotelData',
    //             'labels', 'data',
    //             'bookedRestaurants', 'bookedResorts', 'bookedHotels',
    //             'todaybookedrestaurant', 'thisMonthbookedrestaurant', 'thisYearbookedrestaurant',
    //             'todaybookedresort', 'thisMonthbookedresort', 'thisYearbookedresort',
    //             'todaybookedhotel', 'thisMonthbookedhotel', 'thisYearbookedhotel',
    //             'bookedRestaurant', 'bookedResort', 'bookedHotel'
    //         ));
    //     } else {
    //         return redirect('/login')->with('error', "You need to Login first.");
    //     }
    // }

    public function userdashboard()
    {
        if (Auth::check()) {
            $userId = auth()->id();

            // User Restaurant Area Chart
            $restaurantData = BookingRestaurant::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(popular_count) as total_popular_count')
                ->where('user_id', $userId)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $restaurantLabels = $restaurantData->pluck('month')->map(function($month) {
                return Carbon::createFromFormat('Y-m', $month)->format('M');
            });
            $restaurantPopularCounts = $restaurantData->pluck('total_popular_count');

            // User Resort Area Chart
            $resortData = BookingResort::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(popular_count) as total_popular_count')
                ->where('user_id', $userId)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $resortLabels = $resortData->pluck('month')->map(function($month) {
                return Carbon::createFromFormat('Y-m', $month)->format('M');
            });
            $resortPopularCounts = $resortData->pluck('total_popular_count');

            // User Hotel Area Chart
            $hotelData = BookingHotel::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(popular_count) as total_popular_count')
                ->where('user_id', $userId)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $hotelLabels = $hotelData->pluck('month')->map(function($month) {
                return Carbon::createFromFormat('Y-m', $month)->format('M');
            });
            $hotelPopularCounts = $hotelData->pluck('total_popular_count');

            // All Booked Pie Chart
            $bookedRestaurants = BookingRestaurant::where('user_id', $userId)->count();
            $bookedResorts = BookingResort::where('user_id', $userId)->count();
            $bookedHotels = BookingHotel::where('user_id', $userId)->count();

            $labels = ['Restaurants', 'Resorts', 'Hotels'];
            $data = [$bookedRestaurants, $bookedResorts, $bookedHotels];

            // Get Booked Restaurant with auth id
            $todayDate = Carbon::now()->format('Y-m-d');
            $todayMonth = Carbon::now()->format('m');
            $todayYear = Carbon::now()->format('Y');

            // All Restaurant, Resort and Hotel count with auth id
            $bookedRestaurant = Restaurant::where('user_id', $userId)->count();
            $bookedResort = Resort::where('user_id', $userId)->count();
            $bookedHotel = Hotel::where('user_id', $userId)->count();

            // Resort bookings for today, this month, and this year for the user
            $todaybookedresort = BookingResort::where('user_id', $userId)
                ->whereDate('created_at', $todayDate)
                ->count();
            $thisMonthbookedresort = BookingResort::where('user_id', $userId)
                ->whereMonth('created_at', $todayMonth)
                ->count();
            $thisYearbookedresort = BookingResort::where('user_id', $userId)
                ->whereYear('created_at', $todayYear)
                ->count();

            // Restaurant bookings for today, this month, and this year for the user
            $todaybookedrestaurant = BookingRestaurant::where('user_id', $userId)
                ->whereDate('created_at', $todayDate)
                ->count();
            $thisMonthbookedrestaurant = BookingRestaurant::where('user_id', $userId)
                ->whereMonth('created_at', $todayMonth)
                ->count();
            $thisYearbookedrestaurant = BookingRestaurant::where('user_id', $userId)
                ->whereYear('created_at', $todayYear)
                ->count();

            // Hotel bookings for today, this month, and this year for the user
            $todaybookedhotel = BookingHotel::where('user_id', $userId)
                ->whereDate('created_at', $todayDate)
                ->count();
            $thisMonthbookedhotel = BookingHotel::where('user_id', $userId)
                ->whereMonth('created_at', $todayMonth)
                ->count();
            $thisYearbookedhotel = BookingHotel::where('user_id', $userId)
                ->whereYear('created_at', $todayYear)
                ->count();

            return view('backend-user.newdashboard', compact(
                'restaurantLabels', 'restaurantPopularCounts',
                'resortLabels', 'resortPopularCounts',
                'hotelLabels', 'hotelPopularCounts',
                'labels', 'data',
                'bookedRestaurants', 'bookedResorts', 'bookedHotels',
                'todaybookedrestaurant', 'thisMonthbookedrestaurant', 'thisYearbookedrestaurant',
                'todaybookedresort', 'thisMonthbookedresort', 'thisYearbookedresort',
                'todaybookedhotel', 'thisMonthbookedhotel', 'thisYearbookedhotel',
                'bookedRestaurant', 'bookedResort', 'bookedHotel'
            ));
        } else {
            return redirect('/login')->with('error', "You need to Login first.");
        }
    }

    public function forgetPassword(){

        return view('frontend-auth.forget-password');
    }

    public function forgetPasswordPost(Request $request){

        $request->validate([
            'email' => "required|email|exists:users",
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::send("email.forget-password", ['token' => $token], function ($message) use ($request){
            $message->to($request->email);
            $message->subject("Reset Password");
        });

        return redirect()->route("forget.password")->with("success", "We have sent an email to reset password.");
    }

    public function resetPassword($token){

        return view ("frontend-auth.resetpassword",compact('token'));
    }

    public function resetPasswordPost(Request $request)
    {
        // 表单验证规则
        $request->validate([
            "email" => "required|email|exists:users",
            "password" => "required|string|min:6|confirmed", // confirmed 规则会自动验证 password_confirmation 字段
        ]);

        // 获取请求中的数据
        $email = $request->input('email');
        $token = $request->input('token');

        // 检查密码重置令牌
        $updatePassword = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        // 如果找不到相应的密码重置令牌，则重定向到重置密码页面并显示错误消息
        if (!$updatePassword) {
            return redirect()->route("reset.password")->with("fail", "Invalid token");
        }

        // 使用邮箱查找用户对象
        $user = User::where("email", $email)->first();

        // 对密码进行哈希处理
        // $user->password = Hash::make($request->password);
        $user->password = $request->password;
        $user->save();

        // 删除密码重置令牌
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // 重定向到登录页面并显示成功消息
        return redirect()->route("login")->with("success", "Password reset success.");
    }

    public function showOtpForm($id)
    {
        $user = User::findOrFail($id);

        // 生成随机 OTP
        $otp = rand(100000, 999999);

        // 保存 OTP 到 session
        Session::put('otp', $otp);
        Session::put('otp_user_id', $id);

        // 发送 OTP 到用户的电子邮件
        // Mail::to($user->email)->send(new OtpMail($otp));
        // 发送 OTP 到固定的电子邮件地址
        Mail::to('ahpin7762@gmail.com')->send(new OtpMail($otp));

        return view('frontend-auth.user.otp', ['id' => $id]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|size:6', // 确保数组长度为6
            'otp.*' => 'required|numeric|digits:1', // 确保每个元素是数字且长度为1
            'user_id' => 'required|numeric'
        ]);

        $otp = implode('', $request->input('otp'));
        $userId = $request->input('user_id');

        // 检查 OTP 是否匹配
        if (Session::get('otp') == $otp && Session::get('otp_user_id') == $userId) {
            // OTP 验证成功，重定向到用户 Dashboard
            Session::forget('otp');
            Session::forget('otp_user_id');
            return redirect('/users/dashboard/' . $userId);
        } else {
            // OTP 验证失败，返回错误信息
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }
    }

    public function resendOtp(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::findOrFail($userId);

        // 生成随机 OTP
        $otp = rand(100000, 999999);

        // 保存 OTP 到 session
        Session::put('otp', $otp);
        Session::put('otp_user_id', $userId);

        // 发送 OTP 到用户的电子邮件
        // Mail::to($user->email)->send(new OtpMail($otp));
        // 发送 OTP 到固定的电子邮件地址
        Mail::to('ahpin7762@gmail.com')->send(new OtpMail($otp));

        return response()->json(['success' => 'OTP has been resent successfully.']);
    }

    // 显示用户钱包
    // public function wallet($id)
    // {
    //     $user = User::findOrFail($id);
    //     $wallet = MyWallet::firstOrCreate(
    //         ['user_id' => $id],
    //         [
    //             'user_name' => $user->name,
    //             'profit' => 0,
    //             'balance' => 0,
    //             'refund_price' => 0,
    //             'refund_deposit' => 0
    //         ]
    //     );
    //     // 在这里添加逻辑来处理钱包页面的显示
    //     return view('backend-user.MyWallet', compact('user', 'wallet'));
    // }

    public function wallet($id)
    {
        $user = User::findOrFail($id);
        $wallet = MyWallet::firstOrCreate(
            ['user_id' => $id],
            [
                'user_name' => $user->name,
                'profit' => 0,
                'balance' => 0,
                'refund_price' => 0,
                'refund_deposit' => 0
            ]
        );

        // 获取所有钱包记录
        $walletRecords = MyWallet::where('user_id', $id)->get();

        // 计算总和
        $totalBalance = $walletRecords->sum('balance');
        $totalProfit = $walletRecords->sum('profit');
        $totalRefundDeposit = $walletRecords->sum('refund_deposit');

        // 对 adminwallets 进行分页处理
        $adminwallets = AdminWallet::paginate(10); // 每页显示10条记录

        return view('backend-user.MyWallet', compact('user', 'wallet', 'walletRecords', 'totalBalance', 'totalProfit',
        'totalRefundDeposit', 'adminwallets'));
    }

    // public function showUploadPhotoForm()
    // {
    //     if (Auth::check()) {
    //         return view('frontend-auth.user.user-face-recognition');
    //     } else {
    //         return redirect()->route('frontend-auth.login')->with('error', 'You need to log in first.');
    //     }
    // }

    // public function uploadPhoto(Request $request)
    // {
    //     $request->validate([
    //         'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $user = Auth::user();
    //     $imageName = time().'.'.$request->photo->extension();
    //     $request->photo->move(public_path('images'), $imageName);

    //     // Save the photo to FaceRecognition model
    //     $face = FaceRecognition::updateOrCreate(
    //         ['user_id' => $user->id],
    //         ['photo' => $imageName]
    //     );

    //     return redirect()->route('home', ['id' => $user->id]);
    // }

    // public function showVerifyFaceForm()
    // {
    //     return view('frontend-auth.user.verify-face');
    // }

    // public function verifyFace(Request $request)
    // {
    //     return ["error" => "Face recognition functionality not implemented"];
    // }

    // public function verifyFace(Request $request, FaceRecognitionService $faceRecognitionService)
    // {
    //     $user = Auth::user();
    //     $faceRecognition = $user->faceRecognition;

    //     if (!$faceRecognition) {
    //         return redirect()->route('users.upload-photo')->with('error', 'Please upload a photo first.');
    //     }

    //     $photoPath1 = Storage::path('images/' . $faceRecognition->photo);
    //     $photoPath2 = $request->file('photo')->getPathname();

    //     $result = $faceRecognitionService->verifyFace($photoPath1, $photoPath2);

    //     if (isset($result['match']) && $result['match']) {
    //         return redirect()->route('home', ['id' => $user->id]);
    //     } elseif (isset($result['match']) && !$result['match']) {
    //         return redirect()->route('home')->with('error', 'Face does not match. Please try again.');
    //     } else {
    //         return redirect()->route('home')->with('error', 'Face recognition failed. Please try again.');
    //     }

    // }

}
