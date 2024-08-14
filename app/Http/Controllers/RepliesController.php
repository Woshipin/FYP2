<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentRestaurant;
use App\Models\CommentResort;
use App\Models\CommentHotel;
use App\Models\Restaurant;
use App\Models\Resort;
use App\Models\Hotel;
use App\Models\User;
use App\Models\ReplyRestaurantComment;
use App\Models\ReplyResortComment;
use App\Models\ReplyHotelComment;
use Auth;
use Illuminate\Support\Facades\Validator;

class RepliesController extends Controller
{
    
    public function store(Request $request){

        $commentId = $request->input('comment_id');

        // Retrieve authenticated user's ID and name
        $userId = Auth::id();
        $userName = Auth::user()->name;

        // Create a new reply and associate it with the comment
        $reply = new ReplyRestaurantComment();
        // $reply->restaurant_id = $request->restaurant_id;
        $reply->comment_id = $commentId;
        $reply->user_id = $userId;
        $reply->name = $userName;
        $reply->reply = $request->reply;
        $reply->save();

        return back()->with('success','You has been Reply This Comment!');

    }

    public function destroy($id)
    {
        if (Auth::check()) {

            ReplyRestaurantComment::where('id',$id)->delete();

            return back()->with('success','This Reply has been delete.');

        }else{

            return redirect()->route('login-register')->with('error', 'You need to log in first.');
        }
    }

//-------------------------------------------------------- Resort Reple Comment Area ------------------------------------------------//

    public function replyresortcomment(Request $request){

        $commentId = $request->input('comment_id');

        // Retrieve authenticated user's ID and name
        $userId = Auth::id();
        $userName = Auth::user()->name;

        // Create a new reply and associate it with the comment
        $reply = new ReplyResortComment();
        // $reply->restaurant_id = $request->restaurant_id;
        $reply->comment_id = $commentId;
        $reply->user_id = $userId;
        $reply->name = $userName;
        $reply->reply = $request->reply;
        $reply->save();

        return back()->with('success','You has been Reply This Comment!');

    }

    public function deletereplyresortcomment($id)
    {
        if (Auth::check()) {

            ReplyResortComment::where('id',$id)->delete();

            return back()->with('success','This Reply has been delete.');

        }else{

            return redirect()->route('login-register')->with('error', 'You need to log in first.');
        }
    }

//-------------------------------------------------------- Resort Reple Comment Area ------------------------------------------------//

    public function replyhotelcomment(Request $request){

        $commentId = $request->input('comment_id');

        // Retrieve authenticated user's ID and name
        $userId = Auth::id();
        $userName = Auth::user()->name;

        // Create a new reply and associate it with the comment
        $reply = new ReplyHotelComment();
        // $reply->restaurant_id = $request->restaurant_id;
        $reply->comment_id = $commentId;
        $reply->user_id = $userId;
        $reply->name = $userName;
        $reply->reply = $request->reply;
        $reply->save();

        return back()->with('success','You has been Reply This Comment!');

    }

    public function deletereplyhotelcomment($id)
    {
        if (Auth::check()) {

            ReplyHotelComment::where('id',$id)->delete();

            return back()->with('success','This Reply has been delete.');

        }else{

            return redirect()->route('login-register')->with('error', 'You need to log in first.');
        }
    }

}
