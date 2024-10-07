<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HotelWishlist;
use App\Models\ResortWishlist;
use App\Models\RestaurantWishlist;

class WishlistController extends Controller
{

    // Add and Remove Hotel Wishlist
    public function addHotelToWishlist($hotelId)
    {
        $user = auth()->user();

        // Check if the hotel is already in the wishlist
        if (!$user->wishlist()->where('hotel_id', $hotelId)->exists()) {
            // Add the hotel to the wishlist
            $user->wishlist()->create(['hotel_id' => $hotelId]);

            return redirect()->back()->with('success', 'Hotel added to wishlist');
        }

        return redirect()->back()->with('fail', 'Hotel is already in the wishlist!');
    }

    public function removeHotelFromWishlist($hotelId)
    {
        $user = auth()->user();

        // Remove the hotel from the wishlist
        $user->wishlist()->where('hotel_id', $hotelId)->delete();

        return redirect()->back()->with('success', 'Hotel removed from wishlist');
    }

    // Add and Remove Resort Wishlist
    public function addResortToWishlist($resortId)
    {
        $user = auth()->user();

        // 刷新用户模型的缓存
        $user->refresh();

        // Check if the Resort is already in the wishlist
        if (!$user->resortwishlist()->where('resort_id', $resortId)->exists()) {
            // Add the Resort to the wishlist
            $user->resortwishlist()->create(['resort_id' => $resortId]);

            return redirect()->back()->with('success', 'Resort added to Resortwishlist');
        }

        return redirect()->back()->with('fail', 'Resort is already in the Resortwishlist!');
    }

    public function removeResortFromWishlist($resortId)
    {
        $user = auth()->user();

        // Remove the Resort from the resortwishlist
        $user->resortwishlist()->where('resort_id', $resortId)->delete();

        return redirect()->back()->with('success', 'Resort removed from Resortwishlist');
    }

    // Add and Remove Restaurant Wishlist
    public function addRestaurantToWishlist($restaurantId)
    {
        $user = auth()->user();

        // Check if the Restaurant is already in the wishlist
        if (!$user->restaurantwishlist()->where('restaurant_id', $restaurantId)->exists()) {
            // Add the Restaurant to the wishlist
            $user->restaurantwishlist()->create(['restaurant_id' => $restaurantId]);

            return redirect()->back()->with('success', 'Restaurant added to wishlist');
        }

        return redirect()->back()->with('fail', 'Restaurant is already in the wishlist!');
    }

    public function removeRestaurantFromWishlist($restaurantId)
    {
        $user = auth()->user();

        // Remove the Restaurant from the wishlist
        $user->restaurantwishlist()->where('restaurant_id', $restaurantId)->delete();

        return redirect()->back()->with('success', 'Restaurant removed from wishlist');
    }

    // Show All User Wishlist
    public function showWishlist()
    {
        // 检查用户是否已登录
        if (!auth()->check()) {
            // 如果用户未登录，重定向到登录页面
            return redirect()->route('login')->with('error', '请先登录以查看您的愿望清单。');
        }

        // 获取当前登录用户
        $user = auth()->user();

        // 获取用户的愿望清单
        $hotelWishlists = $user->wishlist()->with('hotel')->get();
        $resortWishlists = $user->resortwishlist()->with('resort')->get();
        $restaurantWishlists = $user->restaurantwishlist()->with('restaurant')->get();

        // 返回视图
        return view('backend-user.user-wishlist.wishlist', compact('resortWishlists', 'hotelWishlists', 'restaurantWishlists'));
    }

}
