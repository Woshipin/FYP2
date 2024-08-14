<?php

namespace App\Services;

use App\Models\Restaurant;
use App\Models\Resort;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;

class RecommendationService
{

    // -------------------------------------------------------完整的full code------------------------------------------------------
    // 获取推荐列表
    public function getRecommendations($userId)
    {
        // 获取用户的评分数据和预订记录
        $userRatings = $this->getUserRatings($userId);
        $userBookings = $this->getUserBookings($userId);

        // 分析用户预订记录，确定用户经常预订的地点
        $mostBookedPlaces = $this->analyzeUserBookings($userBookings);

        // 计算推荐分数
        $recommendations = $this->calculateRecommendations($userRatings, $mostBookedPlaces);

        return $recommendations;
    }

    // 获取用户评分数据
    protected function getUserRatings($userId)
    {
        // 查询用户的评分数据
        $ratings = DB::table('resort_ratings')
            ->select('user_id', 'rateable_id', 'rating', DB::raw("'resort' as type"))
            ->where('user_id', $userId)
            ->union(
                DB::table('hotel_ratings')
                    ->select('user_id', 'rateable_id', 'rating', DB::raw("'hotel' as type"))
                    ->where('user_id', $userId)
            )
            ->union(
                DB::table('restaurant_ratings')
                    ->select('user_id', 'rateable_id', 'rating', DB::raw("'restaurant' as type"))
                    ->where('user_id', $userId)
            )
            ->get()
            ->toArray();

        return $ratings;
    }

    // 获取用户预订记录
    protected function getUserBookings($userId)
    {
        // 查询用户的预订记录
        $resortBookings = DB::table('booking_resorts')
            ->select('user_id', 'resort_id as place_id', DB::raw("'resort' as type"))
            ->where('user_id', $userId)
            ->get()
            ->toArray();

        $hotelBookings = DB::table('booking_hotels')
            ->select('user_id', 'hotel_id as place_id', DB::raw("'hotel' as type"))
            ->where('user_id', $userId)
            ->get()
            ->toArray();

        $restaurantBookings = DB::table('booking_restaurants')
            ->select('user_id', 'restaurant_id as place_id', DB::raw("'restaurant' as type"))
            ->where('user_id', $userId)
            ->get()
            ->toArray();

        // 合并查询结果
        $bookings = array_merge($resortBookings, $hotelBookings, $restaurantBookings);

        return $bookings;
    }

    // 分析用户预订记录
    protected function analyzeUserBookings($userBookings)
    {
        // 分析用户预订记录以确定经常预订的地点
        $mostBookedPlaces = [];

        foreach ($userBookings as $booking) {
            $placeId = $booking->place_id;
            $placeType = $booking->type; // 预订类型
            $key = $placeType . '_' . $placeId; // 使用复合键区分不同类型的地点

            if (!isset($mostBookedPlaces[$key])) {
                $mostBookedPlaces[$key] = [
                    'count' => 0,
                    'type' => $placeType,
                    'place_id' => $placeId // 也存储地点 ID
                ];
            }
            $mostBookedPlaces[$key]['count']++;
        }

        // 按预订频率排序
        uasort($mostBookedPlaces, function ($a, $b) {
            return $b['count'] <=> $a['count'];
        });

        return $mostBookedPlaces;
    }

    // 计算推荐列表
    protected function calculateRecommendations($userRatings, $mostBookedPlaces)
    {
        $recommendations = [];

        foreach ($mostBookedPlaces as $bookingData) {

            $place = null;
            $placeId = $bookingData['place_id'];
            $placeType = $bookingData['type'];
            $bookingCount = $bookingData['count'];

            // 在相应的数据结构中查找地点（餐厅、酒店或度假村）
            if ($placeType === 'restaurant') {
                $place = Restaurant::find($placeId);
            } elseif ($placeType === 'hotel') {
                $place = Hotel::find($placeId);
            } elseif ($placeType === 'resort') {
                $place = Resort::find($placeId);
            }

            if ($place) {
                // 计算平均评分
                $placeRatings = array_filter($userRatings, function ($rating) use ($placeId) {
                    return $rating->rateable_id == $placeId;
                });

                $totalRating = array_reduce($placeRatings, function ($carry, $rating) {
                    return $carry + $rating->rating;
                }, 0);

                $averageRating = count($placeRatings) > 0 ? $totalRating / count($placeRatings) : 0;

                // 创建推荐条目
                $recommendations[] = [
                    'place_type_name' => $placeType,
                    'place_type' => $placeType,
                    'place_name' => $place->name,
                    'place_id' => $place->id,
                    'place_price' => $place->price ?? null,
                    'recommendation_score' => $bookingCount * $averageRating,
                    'image' => $place->image,
                    'description' => $place->description,
                    'averageRating' => $averageRating,
                    'status' => $place->status,
                    'url' => method_exists($place, 'getURL') ? $place->getURL() : null,
                ];
            }
        }

        // 按推荐分数排序
        usort($recommendations, function ($a, $b) {
            return $b['recommendation_score'] <=> $a['recommendation_score'];
        });

        return $recommendations;
    }

    // -----------------------------------------------------完整的 full code 备份------------------------------------------------------
    // public function getRecommendations($userId)
    // {
    //     // 获取用户的评分数据和预订记录
    //     $userRatings = $this->getUserRatings($userId);
    //     $userBookings = $this->getUserBookings($userId);

    //     // 分析用户预订记录，确定用户经常预订的地点
    //     $mostBookedPlaces = $this->analyzeUserBookings($userBookings);

    //     // 计算推荐分数
    //     $recommendations = $this->calculateRecommendations($userRatings, $mostBookedPlaces);

    //     return $recommendations;
    // }

    // protected function getUserRatings($userId)
    // {
    //     // 查询用户的评分数据
    //     $ratings = DB::table('resort_ratings')
    //         ->select('user_id', 'rateable_id', 'rating', DB::raw("'resort' as type"))
    //         ->where('user_id', $userId)
    //         ->union(
    //             DB::table('hotel_ratings')
    //                 ->select('user_id', 'rateable_id', 'rating', DB::raw("'hotel' as type"))
    //                 ->where('user_id', $userId)
    //         )
    //         ->union(
    //             DB::table('restaurant_ratings')
    //                 ->select('user_id', 'rateable_id', 'rating', DB::raw("'restaurant' as type"))
    //                 ->where('user_id', $userId)
    //         )
    //         ->get()
    //         ->toArray();

    //     return $ratings;
    // }

    // protected function getUserBookings($userId)
    // {
    //     // 查询用户的预订记录
    //     $resortBookings = DB::table('booking_resorts')
    //         ->select('user_id', 'resort_id as place_id', DB::raw("'resort' as type"))
    //         ->where('user_id', $userId)
    //         ->get()
    //         ->toArray();

    //     $hotelBookings = DB::table('booking_hotels')
    //         ->select('user_id', 'hotel_id as place_id', DB::raw("'hotel' as type"))
    //         ->where('user_id', $userId)
    //         ->get()
    //         ->toArray();

    //     $restaurantBookings = DB::table('booking_restaurants')
    //         ->select('user_id', 'restaurant_id as place_id', DB::raw("'restaurant' as type"))
    //         ->where('user_id', $userId)
    //         ->get()
    //         ->toArray();

    //     // 合并查询结果
    //     $bookings = array_merge($resortBookings, $hotelBookings, $restaurantBookings);

    //     return $bookings;
    // }

    // protected function analyzeUserBookings($userBookings)
    // {
    //     // Analyze user bookings to determine frequently booked places
    //     $mostBookedPlaces = [];

    //     foreach ($userBookings as $booking) {
    //         $placeId = $booking->place_id;
    //         $placeType = $booking->type; // Booking type
    //         $key = $placeType . '_' . $placeId; // Use composite key to differentiate between place types

    //         if (!isset($mostBookedPlaces[$key])) {
    //             $mostBookedPlaces[$key] = [
    //                 'count' => 0,
    //                 'type' => $placeType,
    //                 'place_id' => $placeId // Store place_id as well
    //             ];
    //         }
    //         $mostBookedPlaces[$key]['count']++;
    //     }

    //     // Sort by booking frequency
    //     uasort($mostBookedPlaces, function ($a, $b) {
    //         return $b['count'] <=> $a['count'];
    //     });

    //     return $mostBookedPlaces;
    // }

    // protected function calculateRecommendations($userRatings, $mostBookedPlaces)
    // {
    //     $recommendations = [];

    //     foreach ($mostBookedPlaces as $bookingData) {

    //         $place = null;
    //         $placeId = $bookingData['place_id'];
    //         $placeType = $bookingData['type'];
    //         $bookingCount = $bookingData['count'];

    //         // Find the place in the respective data structure (restaurant, hotel, or resort)
    //         if ($placeType === 'restaurant') {
    //             $place = Restaurant::find($placeId);
    //         } elseif ($placeType === 'hotel') {
    //             $place = Hotel::find($placeId);
    //         } elseif ($placeType === 'resort') {
    //             $place = Resort::find($placeId);
    //         }

    //         if ($place) {
    //             // Calculate average rating
    //             $placeRatings = array_filter($userRatings, function ($rating) use ($placeId) {
    //                 return $rating->rateable_id == $placeId;
    //             });

    //             $totalRating = array_reduce($placeRatings, function ($carry, $rating) {
    //                 return $carry + $rating->rating;
    //             }, 0);

    //             $averageRating = count($placeRatings) > 0 ? $totalRating / count($placeRatings) : 0;

    //             // Create recommendation entry
    //             $recommendations[] = [
    //                 'place_type_name' => $placeType,
    //                 'place_type' => $placeType,
    //                 'place_name' => $place->name,
    //                 'place_id' => $place->id,
    //                 'place_price' => $place->price ?? null,
    //                 'recommendation_score' => $bookingCount * $averageRating,
    //                 'image' => $place->image,
    //                 'description' => $place->description,
    //                 'averageRating' => $averageRating,
    //                 'status' => $place->status,
    //                 'url' => method_exists($place, 'getURL') ? $place->getURL() : null,
    //             ];
    //         }
    //     }

    //     // Sort recommendations by recommendation score
    //     usort($recommendations, function ($a, $b) {
    //         return $b['recommendation_score'] <=> $a['recommendation_score'];
    //     });

    //     return $recommendations;
    // }

    // -----------------------------------------------------------Fail Code---------------------------------------------------------------
    // public function getRecommendations($userId)
    // {
    //     // 获取用户的评分数据和预订记录
    //     $userRatings = $this->getUserRatings($userId);
    //     $userBookings = $this->getUserBookings($userId);

    //     // 打印预订数据以进行调试
    //     echo "User Bookings:\n";
    //     print_r($userBookings);

    //     // 分析用户预订记录，确定用户经常预订的地点
    //     $mostBookedPlaces = $this->analyzeUserBookings($userBookings);

    //     // 打印分析后的预订记录以进行调试
    //     echo "Most Booked Places:\n";
    //     print_r($mostBookedPlaces);

    //     // 计算推荐分数
    //     $recommendations = $this->calculateRecommendations($userRatings, $mostBookedPlaces);

    //     // 打印推荐结果以进行调试
    //     echo "Recommendations:\n";
    //     print_r($recommendations);

    //     return $recommendations;
    // }

    // protected function getUserRatings($userId)
    // {
    //     // 查询用户的评分数据
    //     $ratings = DB::table('resort_ratings')
    //         ->select('user_id', 'rateable_id', 'rating', DB::raw("'resort' as type"))
    //         ->where('user_id', $userId)
    //         ->union(
    //             DB::table('hotel_ratings')
    //                 ->select('user_id', 'rateable_id', 'rating', DB::raw("'hotel' as type"))
    //                 ->where('user_id', $userId)
    //         )
    //         ->union(
    //             DB::table('restaurant_ratings')
    //                 ->select('user_id', 'rateable_id', 'rating', DB::raw("'restaurant' as type"))
    //                 ->where('user_id', $userId)
    //         )
    //         ->get()
    //         ->toArray();

    //     // 打印用户评分数据以进行调试
    //     echo "User Ratings:\n";
    //     print_r($ratings);

    //     return $ratings;
    // }

    // protected function getUserBookings($userId)
    // {
    //     // 查询用户的预订记录
    //     $resortBookings = DB::table('booking_resorts')
    //         ->select('user_id', 'resort_id as place_id', DB::raw("'resort' as type"))
    //         ->where('user_id', $userId);

    //     $hotelBookings = DB::table('booking_hotels')
    //         ->select('user_id', 'hotel_id as place_id', DB::raw("'hotel' as type"))
    //         ->where('user_id', $userId);

    //     $restaurantBookings = DB::table('booking_restaurants')
    //         ->select('user_id', 'restaurant_id as place_id', DB::raw("'restaurant' as type"))
    //         ->where('user_id', $userId);

    //     // 合并查询结果
    //     $bookings = $resortBookings
    //         ->union($hotelBookings)
    //         ->union($restaurantBookings)
    //         ->get()
    //         ->toArray();

    //     // 打印用户预订数据以进行调试
    //     echo "User Bookings:\n";
    //     print_r($bookings);

    //     return $bookings;
    // }

    // protected function analyzeUserBookings($userBookings)
    // {
    //     // Analyze user bookings to determine frequently booked places
    //     $mostBookedPlaces = [];

    //     foreach ($userBookings as $booking) {
    //         $placeId = $booking->place_id;
    //         $placeType = $booking->type; // Booking type

    //         if (!isset($mostBookedPlaces[$placeId])) {
    //             $mostBookedPlaces[$placeId] = [
    //                 'count' => 0,
    //                 'type' => $placeType
    //             ];
    //         }
    //         $mostBookedPlaces[$placeId]['count']++;
    //     }

    //     // Sort by booking frequency
    //     uasort($mostBookedPlaces, function ($a, $b) {
    //         return $b['count'] <=> $a['count'];
    //     });

    //     // 打印分析结果以进行调试
    //     echo "Most Booked Places:\n";
    //     print_r($mostBookedPlaces);

    //     return $mostBookedPlaces;
    // }

    // protected function calculateRecommendations($userRatings, $mostBookedPlaces)
    // {
    //     $recommendations = [];

    //     foreach ($mostBookedPlaces as $placeId => $bookingData) {
    //         $place = null;
    //         $placeType = $bookingData['type'];
    //         $bookingCount = $bookingData['count'];

    //         // Find the place in the respective data structure (restaurant, hotel, or resort)
    //         if ($placeType === 'restaurant') {
    //             $place = Restaurant::find($placeId);
    //         } elseif ($placeType === 'hotel') {
    //             $place = Hotel::find($placeId);
    //         } elseif ($placeType === 'resort') {
    //             $place = Resort::find($placeId);
    //         }

    //         if ($place) {
    //             // Calculate average rating
    //             $placeRatings = array_filter($userRatings, function ($rating) use ($placeId) {
    //                 return $rating->rateable_id == $placeId;
    //             });
    //             $totalRating = array_reduce($placeRatings, function ($carry, $rating) {
    //                 return $carry + $rating->rating;
    //             }, 0);
    //             $averageRating = count($placeRatings) > 0 ? $totalRating / count($placeRatings) : 0;

    //             // Create recommendation entry
    //             $recommendations[] = [
    //                 'place_type_name' => $placeType,
    //                 'place_type' => $placeType,
    //                 'place_name' => $place->name,
    //                 'place_id' => $place->id,
    //                 'place_price' => $place->price ?? null,
    //                 'recommendation_score' => $bookingCount * $averageRating,
    //                 'image' => $place->image,
    //                 'description' => $place->description,
    //                 'averageRating' => $averageRating,
    //                 'status' => $place->status,
    //                 'url' => method_exists($place, 'getURL') ? $place->getURL() : null,
    //             ];
    //         }
    //     }

    //     // Sort recommendations by recommendation score
    //     usort($recommendations, function ($a, $b) {
    //         return $b['recommendation_score'] <=> $a['recommendation_score'];
    //     });

    //     // 打印推荐结果以进行调试
    //     echo "Recommendations:\n";
    //     print_r($recommendations);

    //     return $recommendations;
    // }

    // public function getRecommendations($userId)
    // {
    //     // 获取用户的评分数据和预订记录
    //     $userRatings = $this->getUserRatings($userId);
    //     $userBookings = $this->getUserBookings($userId);

    //     // 打印预订数据以进行调试
    //     // echo "User Bookings:\n";
    //     // print_r($userBookings);

    //     // 分析用户预订记录，确定用户经常预订的地点
    //     $mostBookedPlaces = $this->analyzeUserBookings($userBookings);

    //     // 打印分析后的预订记录以进行调试
    //     // echo "Most Booked Places:\n";
    //     // print_r($mostBookedPlaces);

    //     // 计算推荐分数
    //     $recommendations = $this->calculateRecommendations($userRatings, $mostBookedPlaces);

    //     // 打印推荐结果以进行调试
    //     echo "Recommendations:\n";
    //     print_r($recommendations);

    //     return $recommendations;
    // }

    // protected function getUserRatings($userId)
    // {
    //     // 查询用户的评分数据
    //     $ratings = DB::table('resort_ratings')
    //         ->select('user_id', 'rateable_id', 'rating', DB::raw("'resort' as type"))
    //         ->where('user_id', $userId)
    //         ->union(
    //             DB::table('hotel_ratings')
    //                 ->select('user_id', 'rateable_id', 'rating', DB::raw("'hotel' as type"))
    //                 ->where('user_id', $userId)
    //         )
    //         ->union(
    //             DB::table('restaurant_ratings')
    //                 ->select('user_id', 'rateable_id', 'rating', DB::raw("'restaurant' as type"))
    //                 ->where('user_id', $userId)
    //         )
    //         ->get()
    //         ->toArray();

    //     // 打印用户评分数据以进行调试
    //     // echo "User Ratings:\n";
    //     // print_r($ratings);

    //     return $ratings;
    // }

    // protected function getUserBookings($userId)
    // {
    //     // 查询用户的预订记录
    //     $resortBookings = DB::table('booking_resorts')
    //         ->select('user_id', 'resort_id as place_id', DB::raw("'resort' as type"))
    //         ->where('user_id', $userId);

    //     $hotelBookings = DB::table('booking_hotels')
    //         ->select('user_id', 'hotel_id as place_id', DB::raw("'hotel' as type"))
    //         ->where('user_id', $userId);

    //     $restaurantBookings = DB::table('booking_restaurants')
    //         ->select('user_id', 'restaurant_id as place_id', DB::raw("'restaurant' as type"))
    //         ->where('user_id', $userId);

    //     // 合并查询结果
    //     $bookings = $resortBookings
    //         ->union($hotelBookings)
    //         ->union($restaurantBookings)
    //         ->get()
    //         ->toArray();

    //     // 打印用户预订数据以进行调试
    //     // echo "User Bookings:\n";
    //     // print_r($bookings);

    //     return $bookings;
    // }

    // protected function analyzeUserBookings($userBookings)
    // {
    //     // Analyze user bookings to determine frequently booked places
    //     $mostBookedPlaces = [];

    //     foreach ($userBookings as $booking) {
    //         $placeId = $booking->place_id;
    //         $placeType = $booking->type; // Booking type
    //         $key = $placeType . '_' . $placeId; // Use composite key to differentiate between place types

    //         if (!isset($mostBookedPlaces[$key])) {
    //             $mostBookedPlaces[$key] = [
    //                 'count' => 0,
    //                 'type' => $placeType,
    //                 'place_id' => $placeId // Store place_id as well
    //             ];
    //         }
    //         $mostBookedPlaces[$key]['count']++;
    //     }

    //     // Sort by booking frequency
    //     uasort($mostBookedPlaces, function ($a, $b) {
    //         return $b['count'] <=> $a['count'];
    //     });

    //     // 打印分析结果以进行调试
    //     // echo "Most Booked Places:\n";
    //     // print_r($mostBookedPlaces);

    //     return $mostBookedPlaces;
    // }

    // protected function calculateRecommendations($userRatings, $mostBookedPlaces)
    // {
    //     $recommendations = [];

    //     foreach ($mostBookedPlaces as $placeId => $bookingData) {

    //         $place = null;
    //         $placeType = $bookingData['type'];
    //         $bookingCount = $bookingData['count'];

    //         // Find the place in the respective data structure (restaurant, hotel, or resort)
    //         if ($placeType === 'restaurant') {
    //             $place = Restaurant::find($placeId);
    //             echo "Restaurant:\n";
    //             print_r($place);
    //         } elseif ($placeType === 'hotel') {
    //             $place = Hotel::find($placeId);
    //             echo "Hotel:\n";
    //             print_r($place);
    //         } elseif ($placeType === 'resort') {
    //             $place = Resort::find($placeId);
    //             // echo "Resort:\n";
    //             // print_r($place);
    //         }

    //         if ($place) {
    //             // Calculate average rating
    //             $placeRatings = array_filter($userRatings, function ($rating) use ($placeId) {
    //                 return $rating->rateable_id == $placeId;
    //             });

    //             // echo "placeRatings:\n";
    //             // print_r($placeRatings);

    //             $totalRating = array_reduce($placeRatings, function ($carry, $rating) {
    //                 return $carry + $rating->rating;
    //             }, 0);

    //             // echo "totalRating:\n";
    //             // print_r($totalRating);

    //             $averageRating = count($placeRatings) > 0 ? $totalRating / count($placeRatings) : 0;

    //             // echo "averageRating:\n";
    //             // print_r($averageRating);

    //             // Create recommendation entry
    //             $recommendations[] = [
    //                 'place_type_name' => $placeType,
    //                 'place_type' => $placeType,
    //                 'place_name' => $place->name,
    //                 'place_id' => $place->id,
    //                 'place_price' => $place->price ?? null,
    //                 'recommendation_score' => $bookingCount * $averageRating,
    //                 'image' => $place->image,
    //                 'description' => $place->description,
    //                 'averageRating' => $averageRating,
    //                 'status' => $place->status,
    //                 'url' => method_exists($place, 'getURL') ? $place->getURL() : null,
    //             ];
    //         } else {
    //             // Handle the case when place is not found
    //             // Log or report the error, or handle it according to your application's logic
    //             // Here, we'll skip adding the recommendation for this place
    //             continue;
    //         }
    //     }

    //     // Sort recommendations by recommendation score
    //     usort($recommendations, function ($a, $b) {
    //         return $b['recommendation_score'] <=> $a['recommendation_score'];
    //     });

    //     // 打印推荐结果以进行调试
    //     // echo "Recommendations:\n";
    //     // print_r($recommendations);

    //     return $recommendations;
    // }

}
