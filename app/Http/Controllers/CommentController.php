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
use App\Models\ReplyToReplyResortComment;
use App\Models\ReplyToReplyHotelComment;
use App\Models\ReplyToReplyRestaurantComment;

class CommentController extends Controller
{

    //--------------------------------------------------- Restaurant Comment Area ------------------------------------------------------//
    // Restaurant Comment Area
    public function CommentRestaurant($id)
    {
        if (Auth::check()) {
            $restaurant = Restaurant::findOrFail($id);
            $comments = $restaurant->comments()->with(['replies.repliesToReplies'])->get();

            $replies = $comments->map(function ($comment) {
                return $comment->replies;
            })->flatten()->filter();

            return view('frontend-auth.frontend-restaurant.comment-restaurant', compact('restaurant', 'comments', 'id', 'replies'));
        } else {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    }

    public function AddRestaurantComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $comment = new CommentRestaurant();
        $comment->user_id = auth()->id();
        $comment->user_name = Auth::user()->name;
        $comment->restaurant_id = $id;
        $comment->comment = $request->comment;
        $comment->save();

        return back()->with('success', 'Your comment has been added successfully.');
    }

    public function deleteRestaurantComment($id)
    {
        $comment = CommentRestaurant::findOrFail($id);
        if ($comment->user_id == Auth::id()) {
            $comment->delete();
            return response()->json(['success' => true, 'message' => 'Comment deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'You can only delete your own comments.']);
    }

    public function storeReplyToReplyRestaurant(Request $request)
    {
        $request->validate([
            'reply_id' => 'required|integer',
            'reply' => 'required|string',
            'parent_id' => 'nullable|integer',
            'parent_type' => 'nullable|string',
        ]);

        // 获取被回复的回复
        $parent = null;
        if ($request->has('parent_id') && $request->has('parent_type')) {
            if ($request->parent_type == 'reply') {
                $parent = ReplyRestaurantComment::find($request->parent_id);
            } elseif ($request->parent_type == 'reply_to_reply') {
                $parent = ReplyToReplyRestaurantComment::find($request->parent_id);
            }
        }

        $replyToReply = new ReplyToReplyRestaurantComment();
        $replyToReply->reply_id = $request->reply_id;
        $replyToReply->user_id = Auth::id();
        $replyToReply->name = Auth::user()->name;
        $replyToReply->reply = $request->reply;

        // 设置 parent_id 和 parent_type
        if ($parent) {
            $replyToReply->parent_id = $parent->id;
            $replyToReply->parent_type = $request->parent_type;
            $replyToReply->parent_name = $parent->name; // 使用 reply_restaurant_comments 的 name
        }

        $replyToReply->save();

        return back()->with('success', 'Reply added successfully.');
    }

    public function deleteReplyToReplyRestaurantComment($id)
    {
        $replyToReply = ReplyToReplyRestaurantComment::findOrFail($id);
        if ($replyToReply->user_id == Auth::id()) {
            $replyToReply->delete();
            return response()->json(['success' => true, 'message' => 'Reply deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'You can only delete your own replies.']);
    }

    //------------------------------------------------------ Resort Comment Area -----------------------------------------------------//

    // Resort Comment Area
    public function ResortComment($id)
    {
        if (Auth::check()) {
            $resort = Resort::findOrFail($id);
            $comments = $resort->comments()->with(['replies.repliesToReplies'])->get();

            $replies = $comments->map(function ($comment) {
                return $comment->replies;
            })->flatten()->filter();

            return view('frontend-auth.frontend-resort.comment-resort', compact('resort', 'comments', 'id', 'replies'));
        } else {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    }

    public function AddResortComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $comment = new CommentResort();
        $comment->user_id = auth()->id();
        $comment->user_name = Auth::user()->name;
        $comment->resort_id = $id;
        $comment->comment = $request->comment;
        $comment->save();

        return back()->with('success', 'Your comment has been added successfully.');
    }

    public function DeleteResortComment($id)
    {
        $comment = CommentResort::findOrFail($id);
        if ($comment->user_id == Auth::id()) {
            $comment->delete();
            return response()->json(['success' => true, 'message' => 'Comment deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'You can only delete your own comments.']);
    }

    public function storeReplyToReply(Request $request)
    {
        $request->validate([
            'reply_id' => 'required|integer',
            'reply' => 'required|string',
            'parent_id' => 'nullable|integer',
            'parent_type' => 'nullable|string',
        ]);

        // 获取被回复的回复
        $parent = null;
        if ($request->has('parent_id') && $request->has('parent_type')) {
            if ($request->parent_type == 'reply') {
                $parent = ReplyResortComment::find($request->parent_id);
            } elseif ($request->parent_type == 'reply_to_reply') {
                $parent = ReplyToReplyResortComment::find($request->parent_id);
            }
        }

        $replyToReply = new ReplyToReplyResortComment();
        $replyToReply->reply_id = $request->reply_id;
        $replyToReply->user_id = Auth::id();
        $replyToReply->name = Auth::user()->name;
        $replyToReply->reply = $request->reply;

        // 设置 parent_id 和 parent_type
        if ($parent) {
            $replyToReply->parent_id = $parent->id;
            $replyToReply->parent_type = $request->parent_type;
            $replyToReply->parent_name = $parent->name; // 使用 reply_resort_comments 的 name
        }

        $replyToReply->save();

        return back()->with('success', 'Reply added successfully.');
    }

    public function deleteReplyToReplyResortComment($id)
    {
        $replyToReply = ReplyToReplyResortComment::findOrFail($id);
        if ($replyToReply->user_id == Auth::id()) {
            $replyToReply->delete();
            return response()->json(['success' => true, 'message' => 'Reply deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'You can only delete your own replies.']);
    }

    //----------------------------------------------------- Hotel Comment Area ------------------------------------------------------//

    // Hotel Comment Area
    public function HotelComment($id)
    {
        if (Auth::check()) {
            $hotel = Hotel::findOrFail($id);
            $comments = $hotel->comments()->with(['replies.repliesToReplies'])->get();

            $replies = $comments->map(function ($comment) {
                return $comment->replies;
            })->flatten()->filter();

            return view('frontend-auth.frontend-hotel.comment-hotel', compact('hotel', 'comments', 'id', 'replies'));
        } else {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    }

    public function AddHotelComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $comment = new CommentHotel();
        $comment->user_id = auth()->id();
        $comment->user_name = Auth::user()->name;
        $comment->hotel_id = $id;
        $comment->comment = $request->comment;
        $comment->save();

        return back()->with('success', 'Your comment has been added successfully.');
    }

    public function DeleteHotelComment($id)
    {
        $comment = CommentHotel::findOrFail($id);
        if ($comment->user_id == Auth::id()) {
            $comment->delete();
            return response()->json(['success' => true, 'message' => 'Comment deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'You can only delete your own comments.']);
    }

    public function storeReplyToReplyHotel(Request $request)
    {
        $request->validate([
            'reply_id' => 'required|integer',
            'reply' => 'required|string',
            'parent_id' => 'nullable|integer',
            'parent_type' => 'nullable|string',
        ]);

        // 获取被回复的回复
        $parent = null;
        if ($request->has('parent_id') && $request->has('parent_type')) {
            if ($request->parent_type == 'reply') {
                $parent = ReplyHotelComment::find($request->parent_id);
            } elseif ($request->parent_type == 'reply_to_reply') {
                $parent = ReplyToReplyHotelComment::find($request->parent_id);
            }
        }

        $replyToReply = new ReplyToReplyHotelComment();
        $replyToReply->reply_id = $request->reply_id;
        $replyToReply->user_id = Auth::id();
        $replyToReply->name = Auth::user()->name;
        $replyToReply->reply = $request->reply;

        // 设置 parent_id 和 parent_type
        if ($parent) {
            $replyToReply->parent_id = $parent->id;
            $replyToReply->parent_type = $request->parent_type;
            $replyToReply->parent_name = $parent->name; // 使用 reply_hotel_comments 的 name
        }

        $replyToReply->save();

        return back()->with('success', 'Reply added successfully.');
    }

    public function deleteReplyToReplyHotelComment($id)
    {
        $replyToReply = ReplyToReplyHotelComment::findOrFail($id);
        if ($replyToReply->user_id == Auth::id()) {
            $replyToReply->delete();
            return response()->json(['success' => true, 'message' => 'Reply deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'You can only delete your own replies.']);
    }

    //---------------------------------------------------- Frontend Comment Area ------------------------------------------------------//
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

}
