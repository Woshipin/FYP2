<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResortRating;
use App\Models\HotelRating;
use App\Models\RestaurantRating;
use App\Models\Resort; // 或者 Hotel, Restaurant
use App\Models\Hotel;
use App\Models\Restaurant;
use Auth;

class RatingController extends Controller
{
    public function resortratings(Request $request)
    {
        $request->validate([
            'rateable_id' => 'required|integer',
            'rateable_type' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if (Auth::check()) {

            ResortRating::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'rateable_id' => $request->rateable_id,
                    'rateable_name' => $request->rateable_name,
                    'rateable_type' => $request->rateable_type,
                ],
                ['rating' => $request->rating]
            );

            return redirect()->back()->with('success', 'Rating Add Successfully!');

        } else {

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    }

    public function hotelratings(Request $request)
    {
        $request->validate([
            'rateable_id' => 'required|integer',
            'rateable_type' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);


        if (Auth::check()) {
            HotelRating::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'rateable_id' => $request->rateable_id,
                    'rateable_name' => $request->rateable_name,
                    'rateable_type' => $request->rateable_type,
                ],
                ['rating' => $request->rating]
            );

            return redirect()->back()->with('success', 'Rating Add Successfully!');
        } else {

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    }

    public function restaurantratings(Request $request)
    {
        $request->validate([
            'rateable_id' => 'required|integer',
            'rateable_type' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);


        if (Auth::check()) {
            RestaurantRating::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'rateable_id' => $request->rateable_id,
                    'rateable_name' => $request->rateable_name,
                    'rateable_type' => $request->rateable_type,
                ],
                ['rating' => $request->rating]
            );

            return redirect()->back()->with('success', 'Rating Add Successfully!');
        } else {

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    }

}
