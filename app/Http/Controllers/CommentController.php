<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentRestaurant;
use App\Models\CommentResort;
use App\Models\CommentHotel;
use App\Models\Restaurant;
use App\Models\Resort;
use App\Models\Hotel;
use App\Models\Comment;
use App\Models\ReplyRestaurantComment;
use App\Models\ReplyResortComment;
use App\Models\ReplyHotelComment;
use App\Models\User;
use Mail;
use Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    // Restaurant Comment Area
    public function CommentRestaurant($id)
    {
        if(Auth::check()){
            $restaurants = Restaurant::find($id);
            $restaurantId = Restaurant::find($id);
            $comments = $restaurants->comments;
            $replies = ReplyRestaurantComment::whereIn('comment_id', $comments->pluck('id'))->get();
            // dd($comments);

            return view('frontend-auth.frontend-restaurant.comment-restaurant', compact('restaurants', 'restaurantId','comments','replies'));

        }else{

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        // $restaurantId = $request->input('restaurant_id');

        $comment = new CommentRestaurant();
        $comment->user_id = auth()->id();
        $comment->user_name = Auth::user()->name;
        $comment->restaurant_id = $id;
        $comment->comment = $request->comment;
        $comment->save();
        // dd($comment);

        return back()->with('success','You Comment has been Created.', $id);
    }

    public function deleteComment(CommentRestaurant $comment, $id)
    {
        if (Auth::check()) {

            CommentRestaurant::where('id', $id)->delete();

            return back()->with('success', 'This Comment and its replies have been deleted.');

        } else {

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    }

//-------------------------------------------------------- Resort Comment Area ------------------------------------------------------//

    // Resort Comment Area
    public function ResortComment($id)
    {
        if(Auth::check()){
            $resorts = Resort::find($id);
            $resortId = Resort::find($id);
            $comments = $resorts->comments;
            $replies = ReplyResortComment::whereIn('comment_id', $comments->pluck('id'))->get();

            return view('frontend-auth.frontend-resort.comment-resort', compact('resorts', 'resortId','comments','replies'));

        }else{

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

    }

    public function AddResortComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        // $restaurantId = $request->input('restaurant_id');

        $comment = new CommentResort();
        $comment->user_id = auth()->id();
        $comment->user_name = Auth::user()->name;
        $comment->resort_id = $id;
        $comment->comment = $request->comment;
        $comment->save();
        // dd($comment);

        return back()->with('success','You Comment has been Created.', $id);

    }

    public function DeleteResortComment(CommentResort $comment, $id)
    {
        if (Auth::check()) {

            CommentResort::where('id', $id)->delete();

            return back()->with('success', 'This Comment and its replies have been deleted.');

        } else {

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    }

    //-------------------------------------------------------- Hotel Comment Area ------------------------------------------------------//

    // Hotel Comment Area
    public function HotelComment($id)
    {
        if(Auth::check()){
            $hotels = Hotel::find($id);
            $hotelId = Hotel::find($id);
            $comments = $hotels->comments;
            $replies = ReplyHotelComment::whereIn('comment_id', $comments->pluck('id'))->get();
            // dd($comments);

            return view('frontend-auth.frontend-hotel.comment-hotel', compact('hotels', 'hotelId','comments','replies'));

        }else{

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

    }

    public function AddHotelComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        // $restaurantId = $request->input('restaurant_id');

        $comment = new CommentHotel();
        $comment->user_id = auth()->id();
        $comment->user_name = Auth::user()->name;
        $comment->hotel_id = $id;
        $comment->comment = $request->comment;
        $comment->save();
        // dd($comment);

        return back()->with('success','You Comment has been Created.', $id);

    }

    public function DeleteHotelComment(CommentHotel $comment, $id)
    {
        if (Auth::check()) {

            CommentHotel::where('id', $id)->delete();

            return back()->with('success', 'This Comment and its replies have been deleted.');

        } else {

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    }

    public function comment(){

        if(Auth::check()){

            return view('frontend-auth.commentus');

        } else {

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    }

    public function commentus(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:1',
            'email' => 'string|required|email|max:100|',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }

        try{

            $comment = new Comment;
            $comment->name = $request->name;
            $comment->email = $request->email;
            $comment->comment = $request->comment;
            $comment->save();

            $data = [
                'user_name' => $request->name,
                'email' => $request->email,
                'comment' => $request->comment // Renamed variable
            ];

            Mail::send('email.commentemail', $data, function($message) use ($data) {
                $message->to('ahpin7762@gmail.com')
                ->subject($data['comment']);
            });

            return back()->with('success','Your Comment has been successfully');

        }catch(e){

            return back()->with('fail', 'Failed to Contact. Please try again.');

        }
    }

    // public function deleteComment(CommentRestaurant $comment)
    // {
    //     if (Auth::check()) {
    //         $reply = ReplyRestaurantComment::where('comment_id', $comment->id);
    //         $commentQuery = CommentRestaurant::where('id', $comment->id);

    //         if ($reply->count() > 0) {
    //             $reply->delete();
    //         }

    //         if ($commentQuery->count() > 0) {
    //             $commentQuery->delete();
    //             return back()->with('success', 'This Comment has been deleted.');
    //         } else {
    //             return back()->with('success', 'No Comment can be deleted.');
    //         }
    //     } else {
    //         return redirect()->route('login-register')->with('error', 'You need to log in first.');
    //     }
    // }

    // public function deleteComment(CommentRestaurant $comment, $id)
    // {
    //     if (Auth::check()) {
    //         $commentId = $comment->id;

    //         $replies = ReplyRestaurantComment::where('comment_id', $commentId);
    //         $commentQuery = CommentRestaurant::where('id', $commentId);

    //         if ($replies->count() > 0) {
    //             $replies->delete();
    //         }

    //         if ($commentQuery->count() > 0) {
    //             $commentQuery->delete();
    //             return back()->with('success', 'This Comment and its replies have been deleted.');
    //         } else {
    //             return back()->with('success', 'No Comment can be deleted.');
    //         }
    //     } else {
    //         return redirect()->route('login-register')->with('error', 'You need to log in first.');
    //     }
    // }
}
