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
        // 检查用户是否已登录
        if (!auth()->check()) {
            return redirect()->back()->with('fail', 'You must be logged in to add hotels to your wishlist.');
        }

        $user = auth()->user();

        // 检查酒店是否已在愿望清单中
        if (!$user->wishlist()->where('hotel_id', $hotelId)->exists()) {
            // 将酒店添加到愿望清单中
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
        // 检查用户是否已登录
        if (!auth()->check()) {
            return redirect()->back()->with('fail', 'You must be logged in to add resorts to your wishlist.');
        }

        $user = auth()->user();

        // 刷新用户模型的缓存
        $user->refresh();

        // 检查度假村是否已在愿望清单中
        if (!$user->resortwishlist()->where('resort_id', $resortId)->exists()) {
            // 将度假村添加到愿望清单中
            $user->resortwishlist()->create(['resort_id' => $resortId]);

            return redirect()->back()->with('success', 'Resort added to wishlist');
        }

        return redirect()->back()->with('fail', 'Resort is already in the wishlist!');
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
        // 检查用户是否已登录
        if (!auth()->check()) {
            return redirect()->back()->with('fail', 'You must be logged in to add restaurants to your wishlist.');
        }

        $user = auth()->user();

        // 检查餐厅是否已在愿望清单中
        if (!$user->restaurantwishlist()->where('restaurant_id', $restaurantId)->exists()) {
            // 将餐厅添加到愿望清单中
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
