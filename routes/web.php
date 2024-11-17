<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ResortController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RecommendationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('auth.newhome');
// });

Route::get('excel', function () {
    return view('staff.excel');
});

//------------------------------------------------------Login and Register Area------------------------------------------------------//
//Login Function
Route::get('/login',[UserController::class,'loadLogin'])->name('login');
Route::post('/loginaccount',[UserController::class,'userlogin'])->name('userlogin');

//------------------------------------------------------Upload Image And Face Recognition Area----------------------------------------//
// Upload Image
// Route::get('/users/upload-photo', [UserController::class, 'showUploadPhotoForm'])->middleware('auth');
// Route::post('/users/upload-photo', [UserController::class, 'uploadPhoto'])->name('users.upload-photo')->middleware('auth');

// Face Recognition
// Route::get('/users/verify-face/{id}', [UserController::class,'showVerifyFaceForm'])->middleware('auth');
// Route::post('/users/verify-face', [UserController::class,'verifyFace'])->name('users.verify-face')->middleware('auth');

// OTP Number Login My Dashboard
Route::get('/users/otp/{id}', [UserController::class, 'showOtpForm'])->name('otp.form');
Route::post('/users/verify-otp', [UserController::class, 'verifyOtp'])->name('otp.verify');
// Resend OTP NUmber
Route::post('/users/resend-otp', [UserController::class, 'resendOtp']);

// Reset Password
Route::get('/forget-password',[UserController::class,'forgetPassword'])->name('forget.password');
Route::post('/forget-password',[UserController::class,'forgetPasswordPost'])->name('forget.password.post');
Route::get('/reset-password/{token}',[UserController::class,'resetPassword'])->name('reset.password');
Route::post('/reset-password',[UserController::class,'resetPasswordPost'])->name('reset.password.post');

//Register Function
Route::get('/register',[UserController::class,'loadRegister']);
Route::post('/registeraccount',[UserController::class,'userregister'])->name('userregister');
// Register Verify
Route::get('/verify-email/{code}', [UserController::class, 'verifyEmail'])->name('verify.email');

//Logout
Route::get('/logout',[UserController::class,'logout'])->name('logout');

//Home Page
Route::get('/',[UserController::class,'home'])->name('home');

//Display User Dashboard Page
Route::get('/users/dashboard/{id}',[UserController::class,'userdashboard'])->middleware('auth')->name('users.dashboard');

//Display User Wallet Page
Route::get('/users/wallet/{id}', [UserController::class, 'wallet'])->name('users.wallet');

// User Contact Page
Route::get('/admin/contact',[ContactController::class,'viewcontact'])->name('admin/contact');

//User Comment Page
Route::get('/comment',[CommentController::class,'Comment'])->name('comment');
//User Comment Function
Route::post('/commentus',[CommentController::class,'commentus'])->name('commentus');

//------------------------------------------------------Admin Control Area------------------------------------------------------//
//Admin Area
//Display Admin Login Page
// 登录和注册页面使用 alreadyLoggedIn 中间件
Route::get('/admin/login', [AdminController::class, 'login'])->middleware('alreadyLoggedIn');
Route::get('/admin/register', [AdminController::class, 'registration'])->middleware('alreadyLoggedIn');

//Register Admin Function
Route::post('/admin/register',[AdminController::class,'registerAdmin'])->name('register-user');
//Login Admin Function
Route::post('/admin/login',[AdminController::class,'loginAdmin'])->name('login-user');

//Display Admin Dashboard Page
Route::get('/admin/dashboard', [AdminController::class, 'admindashboard'])->middleware('isLoggedIn');

//Display Admin Wallet Page
Route::get('/admin/wallet',[AdminController::class,'AdminWallet'])->middleware('isLoggedIn');

//Logout Admin Function
Route::get('/admin/logout',[AdminController::class,'logout']);

//Admin Change Status Function
Route::get('/change-status/{id}',[AdminController::class,'changeStatus']);

//Admin Control Resort
//Admin View All Resort
Route::get('/admin/Resorts',[AdminController::class,'showAllResort'])->name('admin-Resort');
//Add Resort Function
Route::post('admin/AddResort',[AdminController::class,'AdminAddResort'])->name('admin-resort');
//Admin Edit Resort Function
Route::get('admin/editResort/{id}/edit', [AdminController::class, 'AdminEditResort'])->name('admin-editResort');
//Admin Update Resort Function
Route::put('admin/updateResort/{id}', [AdminController::class, 'AdminUpdateResort'])->name('admin-updateResort');
//Admin Delete Resort Function
Route::get('admin/deleteResort/{id}/delete', [AdminController::class, 'AdminDeleteResort'])->name('admin-deleteResort');
//Admin View Resort Follow ID Function
Route::get('/admin/viewResort/{id}/view',[AdminController::class,'AdminViewResort'])->name('admin-viewResort');
//View Resort and Google Map
Route::get('admin/showResortMap/{id}/map',[AdminController::class,'AdminShowResortMap']);
// Show Resort Mutliple Map and Map with id
Route::get('admin/showMap',[AdminController::class,'AdminShowAllResortMap']);
//Search Resort Function
Route::post('admin/searchResort',[AdminController::class,'AdminSearchResort'])->name('admin.searchResort');
//Change Resort Register Status Function
Route::post('/admin/updateResortRegisterStatus/{id}', [AdminController::class, 'updateResortRegisterStatus']);
//Reject Resort Register Status Function
Route::post('/admin/rejectResort/{id}', [AdminController::class, 'rejectResort']);

//Admin Control Restaurant
//Admin View All Restaurant
Route::get('/admin/Restaurants',[AdminController::class,'showAllRestaurant'])->name('admin-Restaurants');
//Admin View Restaurant Follow ID Function
Route::get('/admin/viewRestaurant/{id}/view',[AdminController::class,'AdminViewRestaurant'])->name('admin-viewRestaurant');
//Admin Edit Restaurant Function
Route::get('/admin/editRestaurant/{id}/edit', [AdminController::class, 'AdminEditRestaurant'])->name('admin-editRestaurant');
//Admin Update Restaurant Function
Route::put('/admin/updateRestaurant/{id}', [AdminController::class, 'AdminUpdateRestaurant'])->name('admin-updateRestaurant');
//Admin Delete Restaurant Function
Route::get('/admin/deleteRestaurant/{id}/delete', [AdminController::class, 'AdminDeleteRestaurant'])->name('admin-deleteRestaurant');
//Search Restaurant Function
Route::post('admin/searchRestaurant',[AdminController::class,'AdminSearchRestaurant'])->name('admin.searchRestaurant');
//Change Resort Register Status Function
Route::post('/admin/updateRestaurantRegisterStatus/{id}', [AdminController::class, 'updateRestaurantRegisterStatus']);
//Reject Resort Register Status Function
Route::post('/admin/rejectRestaurant/{id}', [AdminController::class, 'rejectRestaurant']);

//Admin Control Hotel
//Admin View All Hotel
Route::get('/admin/Hotels',[AdminController::class,'showAllHotel'])->name('admin-Hotel');
//Add Hotel Function
Route::post('admin/AddHotel',[AdminController::class,'AdminAddHotel'])->name('admin-hotel');
//Admin Edit Hotel Function
Route::get('admin/editHotel/{id}/edit', [AdminController::class, 'AdminEditHotel'])->name('admin-editHotel');
//Admin Update Hotel Function
Route::put('admin/updateHotel/{id}', [AdminController::class, 'AdminUpdateHotel'])->name('admin-updateHotel');
//Admin Delete Hotel Function
Route::get('admin/deleteHotel/{id}/delete', [AdminController::class, 'AdminDeleteHotel'])->name('admin-deleteHotel');
//Admin View Resort Follow ID Function
Route::get('/admin/viewHotel/{id}/view',[AdminController::class,'AdminViewHotel'])->name('admin-viewHotel');
//Search Hotel Function
Route::post('admin/searchHotel',[AdminController::class,'AdminSearchHotel'])->name('admin.searchHotel');
//Change Resort Register Status Function
Route::post('/admin/updateHotelRegisterStatus/{id}', [AdminController::class, 'updateHotelRegisterStatus']);
//Reject Resort Register Status Function
Route::post('/admin/rejectHotel/{id}', [AdminController::class, 'rejectHotel']);

//Admin Control Table
//Admin View All Table
Route::get('/admin/Tables',[AdminController::class,'showAllTable'])->name('admin-Tables');
//Admin Edit Table Function
Route::get('/admin/editTable/{id}/edit', [AdminController::class, 'AdminEditTable'])->name('admin-editTable');
//Admin Update Table Function
Route::put('/admin/updateTable/{id}', [AdminController::class, 'AdminUpdateTable'])->name('admin-updateTable');
//Admin Delete Table Function
Route::get('/admin/deleteTable/{id}/delete', [AdminController::class, 'AdminDeleteTable'])->name('admin-deleteTable');
//Delete Table Function
Route::get('/deletetable/delete-all', [TableController::class, 'deleteAlltable'])->name('tables.delete');

//Admin Control Room
//Admin View All Room
Route::get('/admin/Rooms',[AdminController::class,'showAllRoom'])->name('admin-Rooms');
//Admin Edit Room Function
Route::get('/admin/editRoom/{id}/edit', [AdminController::class, 'AdminEditRoom'])->name('admin-editRoom');
//Admin Update Room Function
Route::put('/admin/updateRoom/{id}', [AdminController::class, 'AdminUpdateRoom'])->name('admin-updateRoom');
//Admin Delete Room Function
Route::get('/admin/deleteRoom/{id}/delete', [AdminController::class, 'AdminDeleteRoom'])->name('admin-deleteRoom');

//Admin Control Gender
//Admin View All Gender
Route::get('/admin/genders',[GenderController::class,'gender'])->name('admin-genders');
//Admin Add Gender Function
Route::post('/admin/addGender', [GenderController::class, 'addgender'])->name('admin-addgender');
//Admin Edit Gender Function
Route::get('/admin/editGender/{id}/edit', [GenderController::class, 'editGender'])->name('admin-editGender');
//Admin Update Gender Function
Route::put('/admin/updateGender/{id}', [GenderController::class, 'updateGender'])->name('admin-updateGender');
//Admin Delete Gender Function
Route::get('/admin/deleteGender/{id}/delete', [GenderController::class, 'deleteGender'])->name('admin-deleteGender');

//Staff Area
//Display Staff Page
Route::get('/staff',[StaffController::class,'viewstaff']);
//Add Staff Function
Route::post('/addStaff',[StaffController::class,'addStaff'])->name('addStaff');
//Show Staff Function
Route::get('/showStaff',[StaffController::class,'showStaff'])->name('showStaff');
//Edit Staff Function
Route::get('/editStaff/{id}/edit', [StaffController::class, 'editstaff'])->name('editStaff');
//Update Staff Function
Route::put('/updateStaff/{id}', [StaffController::class, 'updatestaff'])->name('updateStaff');
//Delete Staff Function
Route::get('/deleteStaff/{id}/delete', [StaffController::class, 'deletestaff'])->name('deleteStaff');

//------------------------------------------------------User Change Status Area------------------------------------------------------//
//Change Hotel Status Function
Route::get('/changehotel-status/{id}',[HotelController::class,'changehotelStatus']);
//Change Restaurant Status Function
Route::get('/changerestaurant-status/{id}',[RestaurantController::class,'changerestaurantStatus']);
//Change Reosrt Status Function
Route::get('/changeresort-status/{id}',[ResortController::class,'changeresortStatus']);
//Change Room Status Function
Route::get('/changeroom-status/{id}',[RoomController::class,'changeroomStatus']);
//Change Table Status Function
Route::get('/changetable-status/{id}',[TableController::class,'changetableStatus']);

//--------------------------------------------------- User Dashboard Area------------------------------------------------------------//

//User Deposit Page
Route::get('/deposit',[DepositController::class,'viewdeposit'])->name('deposit');
//Delete User Deposit Function
Route::get('/deleteDeposit/{id}/delete', [DepositController::class, 'deleteDeposit'])->name('deleteDeposit');
//MutlipleDelete User Deposit Function
Route::post('/mutlipledeleteDeposit/delete', [DepositController::class, 'deleteMultipleDeposit'])->name('resorts.deleteMultipledeposit');
//Change User Deposit Status Function
Route::get('/changedeposit-status/{id}',[DepositController::class,'changedepositStatus']);
//show Multiple Search Restaurant
Route::get('/DepositSearch',[DepositController::class, 'DepositSearch'])->name('DepositSearch');
//Owner Refund User Deposit Function
Route::get('refunduserdeposit/{id}', [DepositController::class, 'refunduserdeposit'])->name('refunduserdeposit');
//Update Refund User Deposit Function
Route::post('/RefundDepositToUser/{id}', [DepositController::class, 'RefundDepositToUser'])->name('RefundDepositToUser');

// Refund Deposit To User
Route::post('/RefundDeposit',[DepositController::class,'RefundDeposit'])->name('RefundDeposit');
//User Deposit Page
Route::get('/viewrefund',[DepositController::class,'viewRefund'])->name('viewrefund');
//Delete User Deposit Function
Route::get('/deleteRefund/{id}/delete', [DepositController::class, 'deleteRefund'])->name('deleteRefund');
//MutlipleDelete User Deposit Function
Route::post('/mutlipledeleteRefund/delete', [DepositController::class, 'deleteMultipleRefund'])->name('resorts.deleteMultipleRefund');
//show Multiple Search Restaurant
Route::get('/RefundSearch',[DepositController::class, 'RefundSearch'])->name('RefundSearch');

//---------------------------------------------------Resort Area-------------------------------------------------------------------//
//Display Resort Page
Route::get('/resort',[ResortController::class,'viewresort']);
//Add Resort Function
Route::post('/addResort',[ResortController::class,'addResort'])->name('addResort');
//Show Resort Function
Route::get('/showResort',[ResortController::class,'showResort'])->name('showResort');
//Edit Resort Function
Route::get('/editResort/{id}/edit', [ResortController::class, 'editResort'])->name('editResort');
//Update Resort Function
Route::post('/updateResort/{id}', [ResortController::class, 'updateResort'])->name('updateResort');
//Delete Resort Function
Route::get('/deleteResort/{id}/delete', [ResortController::class, 'deleteResort'])->name('deleteResort');
//MutlipleDelete Resort Function
Route::post('/mutlipledeleteResort/delete', [ResortController::class, 'deleteMultiple'])->name('resorts.deleteMultiple');
//show has bookingsrestaurant
Route::get('/bookingsresort',[BookingController::class, 'hasbookingResort']);
//MutlipleDelete Resort Images Function
Route::delete('/resort-image/{id}', [ResortController::class, 'deleteResortImage'])->name('deleteResortImage');

// Verify Resort
Route::post('/booking/verify/resort/{id}', [BookingController::class, 'verifyResortPayment'])->name('booking.verify.resort');
// Checkout Resort
Route::post('/booking/checkout/resort/{id}', [BookingController::class, 'checkoutResort'])->name('booking.checkout.resort');
// cancelling booking resort
Route::post('/booking/cancel/resort/{bookingId}', [BookingController::class, 'cancelBookingResort'])->name('booking.cancel.resort');

//MutlipleDelete Has Booked Function
Route::post('/mutlipledeletebookedresort/delete', [BookingController::class, 'deleteMultiplebookedresort'])->name('resorts.deleteMultiplebookedresort');
//show Real Time Search Restaurant
Route::get('/ResortSearch',[ResortController::class, 'ResortSearch'])->name('ResortSearch');
//View Booked Resort Detail Follow ID Function
Route::get('/viewBookedResort/{id}/view',[BookingController::class,'viewBookedResort'])->name('viewBookedResort');
// GPS Auto Search Resort
Route::get('/resort-gps-search', [ResortController::class, 'ResortgpsSearch'])->name('resort.gps.search');

Route::get('backend-user/backend-resort/resortpromotion/{id}', [ResortController::class, 'showPromotionForm'])->name('resort.promotion.form');
Route::post('backend-user/backend-resort/resortpromotion/{id}', [ResortController::class, 'savePromotionDates'])->name('resort.promotion.save');
Route::get('/resort/{id}/promotion/delete', [ResortController::class, 'deletePromotionDate'])->name('resort.promotion.delete');
Route::post('/resort/promotion/update', [ResortController::class, 'updatePromotionPrice'])->name('resort.promotion.update');

Route::get('backend-user/backend-resort/resortdiscount/{id}', [ResortController::class, 'showDiscountForm'])->name('resort.discount.form');
Route::post('backend-user/backend-resort/resortdiscount/{id}', [ResortController::class, 'saveDiscountDates'])->name('resort.discount.save');
Route::get('/resort/{id}/discount/delete', [ResortController::class, 'deleteDiscountDate'])->name('resort.discount.delete');
Route::post('/resort/discount/update', [ResortController::class, 'updateDiscountPrice'])->name('resort.discount.update');

//---------------------------------------------------Restaurant Area-------------------------------------------------------------//
//Display Restaurant Page
Route::get('/restaurant',[RestaurantController::class,'viewrestaurant']);
//Add Restaurant Function
Route::post('/addRestaurant',[RestaurantController::class,'addRestaurant'])->name('addRestaurant');
//Show Restaurant Function
Route::get('/showRestaurant',[RestaurantController::class,'showRestaurant'])->name('showRestaurant');
//View Restaurant Follow ID Function
Route::get('/viewRestaurant/{id}/view',[RestaurantController::class,'viewRestaurant'])->name('viewRestaurant');
//Edit Restaurant Function
Route::get('/editRestaurant/{id}/edit', [RestaurantController::class, 'editRestaurant'])->name('editRestaurant');
//Update Restaurant Function
Route::put('/updateRestaurant/{id}', [RestaurantController::class, 'updateRestaurant'])->name('updateRestaurant');
//Delete Restaurant Function
Route::get('/deleteRestaurant/{id}/delete', [RestaurantController::class, 'deleteRestaurant'])->name('deleteRestaurant');
//MutlipleDelete Restaurant Function
Route::post('/mutlipledeleterestaurant/delete', [RestaurantController::class, 'deleteMultiplerestaurant'])->name('restaurants.deleteMultiplerestaurant');
//Delete Restaurant Table Function
Route::post('/deleterestauranttable/delete', [RestaurantController::class, 'deleteAllRestaurantTable'])->name('restaurantstable.delete');
//show Multiple Search Restaurant
Route::get('/RestaurantSearch',[RestaurantController::class, 'RestaurantSearch'])->name('RestaurantSearch');
//show has bookingsrestaurant
Route::get('/bookingsrestaurant',[BookingController::class, 'hasbookingRestaurant']);
//MutlipleDelete Restaurant Images Function
Route::delete('/restaurant-image/{id}', [RestaurantController::class, 'deleteRestaurantImage'])->name('deleteRestaurantImage');

// Verify restaurant
Route::post('/booking/verify/restaurant/{id}', [BookingController::class, 'verifyRestaurantPayment'])->name('booking.verify.restaurant');
// Checkout restaurant
Route::post('/booking/checkout/restaurant/{id}', [BookingController::class, 'checkoutRestaurant'])->name('booking.checkout.restaurant');
// cancelling booking restaurant
Route::post('/booking/cancel/restaurant/{bookingId}', [BookingController::class, 'cancelBookingRestaurant'])->name('booking.cancel.restaurant');

//MutlipleDelete Has Booked Function
Route::post('/mutlipledeletebookedrestaurant/delete', [BookingController::class, 'deleteMultiplebookedrestaurant'])->name('restaurants.deleteMultiplebookedrestaurant');
//show Multiple Search Restaurant
Route::get('/BookedRestaurantSearch',[BookingController::class, 'BookedRestaurantSearch'])->name('BookedRestaurantSearch');
//View Booked Restaurant Detail Follow ID Function
Route::get('/viewBookedRestaurant/{id}/view',[BookingController::class,'viewBookedRestaurant'])->name('viewBookedRestaurant');
// GPS Auto Search Restaurant
Route::get('/restaurant-gps-search', [RestaurantController::class, 'RestaurantgpsSearch'])->name('restaurant.gps.search');

//---------------------------------------------------My Restaurant Area---------------------------------------------------------------//
//show Customer bookeds restaurant
Route::get('/mybookingsrestaurant',[BookingController::class, 'mybookedRestaurant']);
//MutlipleDelete Customer bookedsrestaurant Function
Route::post('/customermutlipledeletebookedrestaurant/delete', [BookingController::class, 'customerdeleteMultiplebookedrestaurant'])->name('customer.deleteMultiplebookedrestaurant');
//show Customer bookeds hotel
Route::get('/mybookingshotel',[BookingController::class, 'mybookedHotel']);
//show Customer bookeds hotel
Route::get('/mybookingsresort',[BookingController::class, 'mybookedResort']);

// Extand or cancel resort booking date page
Route::get('/ExtandorCancelResort/{id}',[BookingController::class,'ExtandorCancelResort'])->name('ExtandorCancelResort')->middleware('auth');
// cancel resort booking date
Route::post('/booking/cancel/{id}', [BookingController::class, 'cancelBookingDate'])->name('booking.cancel');

//---------------------------------------------------My Restaurant Area---------------------------------------------------------------//
//checkout booked restaurant
Route::post('paymentrestaurant/{id}/view/{table_id}', [BookingController::class, 'processPaymentRestaurant'])->name('process.payment.restaurant');
//checkout booked hotel
Route::post('paymenthotel/{id}/view/{room_id}', [BookingController::class, 'processPaymentHotel'])->name('process.payment.hotel');
// Checkout booked resort
Route::post('paymentresort/{id}/view', [BookingController::class, 'processPaymentResort'])->name('process.payment.resort');

//---------------------------------------------------Hotel Area---------------------------------------------------------------//
//Display Hotel Page
Route::get('/hotel',[HotelController::class,'index']);
//Add Hotel Function
Route::post('/addHotel',[HotelController::class,'addHotel'])->name('addHotel');
//Show Hotel Function
Route::get('/showHotel',[HotelController::class,'showHotel'])->name('showHotel');
//Edit Hotel Function
Route::get('/editHotel/{id}/edit', [HotelController::class, 'editHotel'])->name('editHotel');
//Update Hotel Function
Route::put('/updateHotel/{id}', [HotelController::class, 'updateHotel'])->name('updateHotel');
//Delete Hotel Function
Route::get('/deleteHotel/{id}/delete', [HotelController::class, 'deleteHotel'])->name('deleteHotel');
//View Hotel Follow ID Function
Route::get('/viewHotel/{id}/view',[HotelController::class,'viewHotel'])->name('viewHotel');
//MutlipleDelete Hotel Function
Route::post('/mutlipledeletehotel/delete', [HotelController::class, 'mutlipledeletehotel'])->name('hotels.mutlipledeletehotel');
//MutlipleDelete Room Function
Route::post('/mutlipledeleterooms/delete', [HotelController::class, 'mutlipledeleterooms'])->name('rooms.mutlipledeleterooms');
//show has bookingsrestaurant
Route::get('/bookingshotel',[BookingController::class, 'hasbookingHotel']);
//MutlipleDelete Hotel Images Function
Route::delete('/hotel-image/{id}', [HotelController::class, 'deleteHotelImage'])->name('deleteHotelImage');

// Verify hotel
Route::post('/booking/verify/hotel/{id}', [BookingController::class, 'verifyHotelPayment'])->name('booking.verify.hotel');
// Checkout hotel
Route::post('/booking/checkout/hotel/{id}', [BookingController::class, 'checkoutHotel'])->name('booking.checkout.hotel');
// cancelling booking hotel
Route::post('/booking/cancel/hotel/{bookingId}', [BookingController::class, 'cancelBookingHotel'])->name('booking.cancel.hotel');

//MutlipleDelete Has Booked Function
Route::post('/mutlipledeletebookedhotel/delete', [BookingController::class, 'deleteMultiplebookedhotel'])->name('hotels.deleteMultiplebookedhotel');
//show Multiple Search Hotel
Route::get('/HotelSearch',[HotelController::class, 'HotelSearch'])->name('HotelSearch');
//View Booked Hotel Detail Follow ID Function
Route::get('/viewBookedHotel/{id}/view',[BookingController::class,'viewBookedHotel'])->name('viewBookedHotel');
// GPS Auto Search Hotel
Route::get('/hotel-gps-search', [HotelController::class, 'HotelgpsSearch'])->name('hotel.gps.search');

//---------------------------------------------------Table Area--------------------------------------------------------------//
//Display Table Page
// Route::get('/tabel',[TableController::class,'showTables']);
//Add Table Function
Route::post('/addTable',[TableController::class,'addTable'])->name('addTable');
//Show Table Function
Route::get('/showTable',[TableController::class,'showTables'])->name('showTable');
//Edit Table Function
Route::get('/editTable/{id}/edit', [TableController::class, 'editTable'])->name('editTable');
//Update Table Function
Route::put('/updateTable/{id}', [TableController::class, 'updateTable'])->name('updateTable');
//Delete Table Function
Route::get('/deleteTable/{id}/delete', [TableController::class, 'deleteTable'])->name('deleteTable');
//MutlipleDelete Table Function
Route::post('/mutlipledeletetable/delete', [TableController::class, 'deleteMultipletable'])->name('tables.deleteMultipletable');

//---------------------------------------------------Room Area----------------------------------------------------------------//
//Display Room Page
// Route::get('/room',[RoomController::class,'index']);
//Add Room Function
Route::post('/addRoom',[RoomController::class,'addRoom'])->name('addRoom');
//Show Room Function
Route::get('/showRoom',[RoomController::class,'showRoom'])->name('showRoom');
//Edit Room Function
Route::get('/editRoom/{id}/edit', [RoomController::class, 'editRoom'])->name('editRoom');
//Update Room Function
Route::put('/updateRoom/{id}', [RoomController::class, 'updateRoom'])->name('updateRoom');
//Delete Room Function
Route::get('/deleteRoom/{id}/delete', [RoomController::class, 'deleteRoom'])->name('deleteRoom');
//MutlipleDelete Room Function
Route::post('/mutlipledeleteroom/delete', [RoomController::class, 'mutlipledeleteroom'])->name('rooms.mutlipledeleteroom');

//---------------------------------------------------Has Booked Search Area------------------------------------------------------------//
//show Multiple Search Has Booked Hotel
Route::get('/hashotelSearch',[BookingController::class, 'hashotelSearch'])->name('hashotelSearch');
//show Multiple Search Has Booked Restaurant
Route::get('/hasrestaurantSearch',[BookingController::class, 'hasrestaurantSearch'])->name('hasrestaurantSearch');
//show Multiple Search Has Booked Resort
Route::get('/hasresortSearch',[BookingController::class, 'hasresortSearch'])->name('hasresortSearch');

//---------------------------------------------------Verify Booked Area-------------------------------------------------------------//
Route::get('/verify/resort/{resortId}', [BookingController::class, 'verifyResort'])->name('verify.resort');
Route::get('/verify/restaurant/{restaurantId}', [BookingController::class, 'verifyRestaurant'])->name('verify.restaurant');
Route::get('/verify/hotel/{hotelId}', [BookingController::class, 'verifyHotel'])->name('verify.hotel');

//---------------------------------------------------Add To Wishlist Area-------------------------------------------------------------//
// Hotel Wishlist
Route::post('/wishlist/add/hotel/{hotelId}', [WishlistController::class, 'addHotelToWishlist']);
Route::get('/userwishlist', [WishlistController::class, 'showWishlist'])->name('wishlist.show');
Route::delete('/wishlist/remove/hotel/{hotelId}', [WishlistController::class, 'removeHotelFromWishlist']);

// Resort Wishlist
Route::post('/wishlist/add/resort/{resortId}', [WishlistController::class, 'addResortToWishlist']);
// Route::get('/wishlist', [WishlistController::class, 'showWishlist'])->name('wishlist.show');
Route::delete('/wishlist/remove/resort/{resortId}', [WishlistController::class, 'removeResortFromWishlist']);

// Restaurant Wishlist
Route::post('/wishlist/add/restaurant/{restaurantId}', [WishlistController::class, 'addRestaurantToWishlist']);
// Route::get('/wishlist', [WishlistController::class, 'showWishlist'])->name('wishlist.show');
Route::delete('/wishlist/remove/restaurant/{restaurantId}', [WishlistController::class, 'removeRestaurantFromWishlist']);


//------------------------------------------------------Frontend Area----------------------------------------------------------//
// Frontend All Resort
Route::get('/allResort',[ResortController::class,'AllResort'])->name('frontend-resort');
// New View New Resort Detail Follow ID Function
Route::get('/Resortdetail/{id}/view',[ResortController::class,'ResortDetail'])->name('resort-detail');
//show Real Time Search Resort
Route::get('/resortsearch',[ResortController::class, 'frontendresortsearch'])->name('resortsearch');
//show Image Search Resort
Route::post('/uploadAndSearch', [ResortController::class, 'uploadAndSearch'])->name('uploadAndSearch');

// ---------------------------------------------------Frontend All Restaurant---------------------------------------------------//
Route::get('/allRestaurant',[RestaurantController::class,'allRestaurant'])->name('frontend-restaurant');
// New View New Restaurant Detail Follow ID Function
Route::get('/Restaurantdetail/{id}/view',[RestaurantController::class,'RestaurantDetail'])->name('restaurant-detail');
//show Multiple Search Restaurant
Route::get('/restaurantsearch',[RestaurantController::class, 'frontendrestaurantsearch'])->name('restaurantsearch');
//show Image Search Restaurant
Route::post('/uploadAndSearchRestaurants', [RestaurantController::class, 'uploadAndSearchRestaurants'])->name('uploadAndSearchRestaurants');

// ---------------------------------------------------Frontend All Hotel---------------------------------------------------------//
Route::get('/allHotel',[HotelController::class,'AllHotel'])->name('frontend-hotel');
// New View New Restaurant Detail Follow ID Function
Route::get('/Hoteldetail/{id}/view',[HotelController::class,'HotelDetail'])->name('hotel-detail');
//show Multiple Search Hotel
Route::get('/hotelsearch',[HotelController::class, 'frontendhotelsearch'])->name('hotelsearch');
//show Image Search Hotel
Route::post('/uploadAndSearchHotels', [HotelController::class, 'uploadAndSearchHotels'])->name('uploadAndSearchHotels');

//---------------------------------------------------User Contact Page--------------------------------------------------------//
Route::get('contact',[ContactController::class,'contact'])->name('contact');
// Contact US
Route::post('/contactus',[ContactController::class,'contactus'])->name('contactus');

// Admin Reply User
Route::post('/send-reply', [ContactController::class, 'sendReply'])->name('send.reply');
Route::post('/customer/send-reply', [ContactController::class, 'CustomerSendReply'])->name('customer.send.reply');


//------------------------------------------------------Frontend Booking Restaurant------------------------------------------------------//
Route::get('/booking/{id}',[BookingController::class,'bookingpage'])->name('bookingrestaurant')->middleware('auth');
Route::post('/bookingsrestaurant', [BookingController::class, 'bookingrestaurant'])->middleware('auth');
Route::post('/check-bookings', [BookingController::class, 'checkBookings']);

//Frontend Booking Resort
Route::get('/bookingresort/{id}',[BookingController::class,'bookingresortpage'])->name('bookingresort')->middleware('auth');
Route::post('/bookingsresort', [BookingController::class, 'bookingresort'])->middleware('auth');

//Frontend Booking Hotel
Route::get('/bookinghotel/{id}',[BookingController::class,'bookinghotelpage'])->name('bookinghotel')->middleware('auth');
Route::post('/bookingshotel', [BookingController::class, 'bookinghotel'])->middleware('auth');


//------------------------------------------------------Frontend Comment Area------------------------------------------------------//
//------------------------------------------------------Frontend Restaurant Comment and Reply Area------------------------------------------------------//
// 添加评论
Route::post('/restaurants/{id}/comment', [CommentController::class, 'AddRestaurantComment'])->name('addRestaurantComment');

// 删除评论
Route::delete('/restaurants/comment/{id}', [CommentController::class, 'deleteRestaurantComment'])->name('deleteRestaurantComment');

// 回复评论
Route::post('/replyrestaurantcomment', [RepliesController::class, 'replyrestaurantcomment'])->name('replyrestaurantcomment');

// 删除回复的评论
Route::delete('/deletereplyrestaurantcomment/{id}', [RepliesController::class, 'deletereplyrestaurantcomment'])->name('deletereplyrestaurantcomment');

// 回复到回复的评论
Route::post('/restaurants/reply', [CommentController::class, 'storeReplyToReplyRestaurant'])->name('storeReplyToReplyRestaurant');

// 删除"回复到回复"的评论
Route::delete('/deletereplytoreplyrestaurantcomment/{id}', [CommentController::class, 'deleteReplyToReplyRestaurantComment'])->name('deleteReplyToReplyRestaurantComment');

// 显示评论页面
Route::get('/restaurants/{id}/comment', [CommentController::class, 'CommentRestaurant'])->name('restaurants.comment');

//--------------------------------------------------- Resort Comment and Reply Area ------------------------------------------------------//
// 添加评论
Route::post('/resorts/{id}/comment', [CommentController::class, 'AddResortComment'])->name('addResortComment');

// 删除评论
Route::delete('/resorts/comment/{id}', [CommentController::class, 'DeleteResortComment'])->name('deleteResortComment');

// 回复评论
Route::post('/replyresortcomment', [RepliesController::class, 'replyresortcomment'])->name('replyresortcomment');

// 删除回复的评论
Route::delete('/deletereplyresortcomment/{id}', [RepliesController::class, 'deletereplyresortcomment'])->name('deletereplyresortcomment');

// 回复到回复的评论
Route::post('/resorts/reply', [CommentController::class, 'storeReplyToReply'])->name('storeReplyToReply');

// 删除"回复到回复"的评论
Route::delete('/deletereplytoreplyresortcomment/{id}', [CommentController::class, 'deleteReplyToReplyResortComment'])->name('deleteReplyToReplyResortComment');

// 显示评论页面
Route::get('/resorts/{id}/comment', [CommentController::class, 'ResortComment'])->name('resorts.comment');

//--------------------------------------------------- Hotel Comment and Reply Area------------------------------------------------------//
// 添加评论
Route::post('/hotels/{id}/comment', [CommentController::class, 'AddHotelComment'])->name('addHotelComment');

// 删除评论
Route::delete('/hotels/comment/{id}', [CommentController::class, 'DeleteHotelComment'])->name('deleteHotelComment');

// 回复评论
Route::post('/replyhotelcomment', [RepliesController::class, 'replyhotelcomment'])->name('replyhotelcomment');

// 删除回复的评论
Route::delete('/deletereplyhotelcomment/{id}', [RepliesController::class, 'deletereplyhotelcomment'])->name('deletereplyhotelcomment');

// 回复到回复的评论
Route::post('/hotels/reply', [CommentController::class, 'storeReplyToReplyHotel'])->name('storeReplyToReplyHotel');

// 删除"回复到回复"的评论
Route::delete('/deletereplytoreplyhotelcomment/{id}', [CommentController::class, 'deleteReplyToReplyHotelComment'])->name('deleteReplyToReplyHotelComment');

// 显示评论页面
Route::get('/hotels/{id}/comment', [CommentController::class, 'HotelComment'])->name('hotels.comment');

//----------------------------------------------------Frontend User Contact Hotel Onwer Area------------------------------------------------------//
//Display Contact User Hotel Page
Route::get('hotels/{id}/contact', [ContactController::class, 'hotelusercontact'])->name('hotels.usercontact');
//User Contact Owner Hotel Page
Route::post('/contacthotel', [ContactController::class, 'contacthotel'])->name('contacthotel');
//Display Contact User Hotel Page
Route::get('viewusercontact', [ContactController::class, 'viewusercontact'])->name('viewusercontact');
//Delete User Contact
Route::delete('/contact/{id}/delete', [ContactController::class, 'DeleteContact'])->name('contact.delete');

//---------------------------------------------- Frontend User Contact Restaurant Onwer Area------------------------------------------------------//
//Display Contact User Hotel Page
Route::get('restaurants/{id}/contact', [ContactController::class, 'restaurantusercontact'])->name('restaurants.contact');
//User Contact Owner Hotel Page
Route::post('/contactrestaurant', [ContactController::class, 'contactrestaurant'])->name('contactrestaurant');
//Display Contact User Hotel Page
// Route::get('viewrestaurantcontact', [ContactController::class, 'viewrestaurantcontact'])->name('viewrestaurantcontact');

//---------------------------------------------- Frontend User Contact Resort Onwer Area------------------------------------------------------//
//Display Contact User Hotel Page
Route::get('resorts/{id}/contact', [ContactController::class, 'resortusercontact'])->name('resorts.contact');
//User Contact Owner Hotel Page
Route::post('/contactresort', [ContactController::class, 'contactresort'])->name('contactresort');
//Display Contact User Hotel Page
// Route::get('viewresortcontact', [ContactController::class, 'viewresortcontact'])->name('viewresortcontact');

//----------------------------------------------------Frontend ReplyComment Area------------------------------------------------------//
// Reply and delete Restaurant Comment
// ---------------------------------------------------Reply Comment follow Comment Id in Restaurant-----------------------------------//
// Route::post('/reply/store', [RepliesController::class, 'store'])->name('reply.store');
// //Delete Reply Comment follow comment id Function in Restaurant
// Route::get('/replies/{id}/delete', [RepliesController::class, 'destroy'])->name('deleteReply');

// Reply and delete Resort Comment
// ---------------------------------------------------Reply Comment follow Comment Id in Resort---------------------------------------//
// Route::post('/replyresortcomment', [RepliesController::class, 'replyresortcomment'])->name('replyresortcomment');

// // 删除回复的评论
// Route::get('/deletereplyresortcomment/{id}/delete', [RepliesController::class, 'deletereplyresortcomment'])->name('deletereplyresortcomment');

// Route::post('/resorts/reply', [CommentController::class, 'storeReplyToReply'])->name('storeReplyToReply');

// Route::get('/deletereplyresortcomment/{id}/delete', [RepliesController::class, 'deletereplyresortcomment'])->name('deletereplyresortcomment');

// ---------------------------------------------------Reply and delete Hotel Comment---------------------------------------------------//
// Reply Comment follow Comment Id in Hotel
// Route::post('/replyhotelcomment', [RepliesController::class, 'replyhotelcomment'])->name('replyhotelcomment');
// //Delete Reply Comment follow comment id Function in Hotel
// Route::get('/deletereplyhotelcomment/{id}/delete', [RepliesController::class, 'deletereplyhotelcomment'])->name('deletereplyhotelcomment');

//------------------------------------------------------ Export and Import Area------------------------------------------------------//
//Export and Import Staff Function
Route::post('/import-staff', [ImportController::class, 'importStaff'])->name('import-staff');
Route::get('/export-staff', [ExportController::class, 'exportStaff'])->name('export-staff');

//Export and Import Resort Function
Route::post('/import-resort', [ImportController::class, 'importResort'])->name('import-resort');
Route::get('/export-resort', [ExportController::class, 'exportResort'])->name('export-resort');

//Export and Import Hotel Function
Route::post('/import-hotel', [ImportController::class, 'importHotel'])->name('import-hotel');
Route::get('/export-hotel', [ExportController::class, 'exportHotel'])->name('export-hotel');

//Export and Import Restaurant Function
Route::post('/import-restaurant', [ImportController::class, 'importRestaurant'])->name('import-restaurant');
Route::get('/export-restaurant', [ExportController::class, 'exportRestaurant'])->name('export-restaurant');

//Export and Import Room Function
Route::post('/import-room', [ImportController::class, 'importRoom'])->name('import-room');
Route::get('/export-room', [ExportController::class, 'exportRoom'])->name('export-room');

//Export and Import Table Function
Route::post('/import-table', [ImportController::class, 'importTable'])->name('import-table');
Route::get('/export-table', [ExportController::class, 'exportTable'])->name('export-table');

//Export Contact Function
Route::get('/export-contact', [ExportController::class, 'exportContact'])->name('export-contact');

//Export Booked Restaurant Function
Route::get('/export-bookedRestaurant', [ExportController::class, 'exportBookedRestaurant'])->name('export-bookedRestaurant');
//Export Booked Resort Function
Route::get('/export-bookedResort', [ExportController::class, 'exportBookedResort'])->name('export-bookedResort');
//Export Booked Hotel Function
Route::get('/export-bookedHotel', [ExportController::class, 'exportBookedHotel'])->name('export-bookedHotel');

//Export Deposit Function
Route::get('/export-deposit', [ExportController::class, 'exportDeposit'])->name('export-deposit');

//Export Sales Function
Route::get('/export-sales', [ExportController::class, 'exportSales'])->name('export-sales');


//------------------------------------------------------ Staff PDF Area------------------------------------------------------//
//View Staff In PDF
Route::post('staff/view-pdf', [PDFController::class, 'viewStaffPDF'])->name('viewstaff-pdf');
//Download Staff In PDF
Route::post('staff/download-pdf', [PDFController::class, 'downloadStaffPDF'])->name('downloadstaff-pdf');

//------------------------------------------------------ Dashboard PDF Area------------------------------------------------------//
//View Dashboard In PDF
Route::post('dashboard/view-pdf', [PDFController::class, 'viewdashboardPDF'])->name('viewdashboard-pdf');
//Download Dashboard In PDF
Route::post('dashboard/download-pdf', [PDFController::class, 'downloaddashboardPDF'])->name('downloaddashboard-pdf');

//------------------------------------------------------ Booked Hotel PDF Area------------------------------------------------------//
//View Hotel In PDF
Route::post('hotel/view-pdf', [PDFController::class, 'viewBookedHotelPDF'])->name('viewhotel-pdf');
//Download Hotel In PDF
Route::post('bookedhotel/download-pdf', [PDFController::class, 'downloadBookedHotelPDF'])->name('downloadbookedhotel-pdf');

//------------------------------------------------------ Booked Resort PDF Area------------------------------------------------------//
//View Resort In PDF
Route::post('resort/view-pdf', [PDFController::class, 'viewresortPDF'])->name('viewresort-pdf');
//Download Resort In PDF
Route::post('bookedresort/download-pdf', [PDFController::class, 'downloadBookedResortPDF'])->name('downloadbookedresort-pdf');

//------------------------------------------------------ Booked Restaurant PDF Area------------------------------------------------------//
//View Restaurant In PDF
Route::post('restaurant/view-pdf', [PDFController::class, 'viewrestaurantPDF'])->name('viewrestaurant-pdf');
//Download Restaurant In PDF
Route::post('bookedrestaurant/download-pdf', [PDFController::class, 'downloadBookedRestaurantPDF'])->name('downloadbookedrestaurant-pdf');

//------------------------------------------------------ Booked Hotel Detail PDF Area------------------------------------------------------//
//View Booked Hotel Detail In PDF
Route::get('/download-bookedhotel-pdf/{bookingId}', [PDFController::class, 'downloadBookedHotelDetailPdf'])->name('download.bookedhotel.pdf');
//View Booked Restaurant Detail In PDF
Route::get('/download-bookedresort-pdf/{bookingId}', [PDFController::class, 'downloadBookedResortDetailPdf'])->name('download.bookedresort.pdf');
//View Booked Restaurant Detail In PDF
Route::get('/download-bookedrestaurant-pdf/{bookingId}', [PDFController::class, 'downloadBookedRestaurantDetailPdf'])->name('download.bookedrestaurant.pdf');

//------------------------------------------------------ Download Template Area------------------------------------------------------//
//-----------------------------------------------Download Hotel Excel Template Area--------------------------------------------------//
Route::get('/Hotel-Excel-Template', function () {
    $path = public_path('Excel-File/HotelTemplate.xlsx');
    $headers = ['Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    return response()->download($path, 'HotelTemplate.xlsx', $headers);
})->name('Hotel.Excel.Template');

//-----------------------------------------------Download Restaurant Excel Template Area--------------------------------------------------//
Route::get('/Restaurant-Excel-Template', function () {
    $path = public_path('Excel-File/RestaurantTemplate.xlsx');
    $headers = ['Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    return response()->download($path, 'RestaurantTemplate.xlsx', $headers);
})->name('Restaurant.Excel.Template');

//-----------------------------------------------Download Resort Excel Template Area--------------------------------------------------//
Route::get('/Resort-Excel-Template', function () {
    $path = public_path('Excel-File/ResortTemplate.xlsx');
    $headers = ['Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    return response()->download($path, 'ResortTemplate.xlsx', $headers);
})->name('Resort.Excel.Template');

//-----------------------------------------------Download Table Excel Template Area--------------------------------------------------//
Route::get('/Table-Excel-Template', function () {
    $path = public_path('Excel-File/TableTemplate.xlsx');
    $headers = ['Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    return response()->download($path, 'TableTemplate.xlsx', $headers);
})->name('Table.Excel.Template');

//-----------------------------------------------Download Room Excel Template Area--------------------------------------------------//
Route::get('/Room-Excel-Template', function () {
    $path = public_path('Excel-File/RoomTemplate.xlsx');
    $headers = ['Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    return response()->download($path, 'RoomTemplate.xlsx', $headers);
})->name('Room.Excel.Template');

//------------------------------------------------------ Rating Area------------------------------------------------------//
Route::post('/resortratings', [RatingController::class, 'resortratings'])->name('resortratings');
Route::post('/hotelratings', [RatingController::class, 'hotelratings'])->name('hotelratings');
Route::post('/restaurantratings', [RatingController::class, 'restaurantratings'])->name('restaurantratings');

//------------------------------------------------------ AI Recommendation Area------------------------------------------------------//
Route::get('/recommendations', [RecommendationController::class, 'getRecommendations'])
    ->middleware('auth')
    ->name('recommendations');

//------------------------------------------------------ AI Chat Bot Area------------------------------------------------------//
// Route::post('/chat', [ChatbotController::class, 'chat']);
Route::post('/AISearch', [ChatbotController::class, 'AISearch']);

//------------------------------------------------------ Fail Area------------------------------------------------------//

// Route::get('/recommendation',[RecommendationController::class,'recommendation'])->name('recommendation');

Route::get('/recommendations', [RecommendationController::class, 'getRecommendations']);

// Show Resort Mutliple Map and Map with id
Route::get('/showMap',[ResortController::class,'showAllResortMap']);
//View Resort and Google Map
Route::get('/showResortMap/{id}/map',[ResortController::class,'showResortMap']);
// Route::get('/showMap/{id}',[ResortController::class,'showMap']);

// Show Hotel Mutliple Map and Map with id
Route::get('/showHotelMap',[HotelController::class,'showAllHotelMap']);
//View Hotel and Google Map
Route::get('/showHotelMap/{id}/map',[HotelController::class,'showHotelMap']);

// Other Resort Page
Route::get('/aaa',[ResortController::class,'aaa']);
// Route::get('/bbb',[ResortController::class,'bbb']);

//View Resort In PDF
// Route::post('resort/view-pdf', [PDFController::class, 'viewResortPDF'])->name('viewresort-pdf');
//Download Resort In PDF
// Route::post('resort/download-pdf', [PDFController::class, 'downloadResortPDF'])->name('downloadresort-pdf');

//User Area
//Login and Register Page
// Route::get('/login-register', [UserController::class, 'showLoginPage'])->name('login-register');

//Login and Register Function
// Route::post('/login&register1',[UserController::class,'userLogin'])->name('userLogin');
// Route::post('/login&register',[UserController::class,'userRegister'])->name('userRegister');

// Paypal Payment
Route::get('paypal/success', [BookingController::class, 'paypalSuccess'])->name('paypal.success');
Route::get('paypal/cancel', [BookingController::class, 'paypalCancel'])->name('paypal.cancel');
