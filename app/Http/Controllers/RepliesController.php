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

    public function replyrestaurantcomment(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|integer',
            'reply' => 'required|string',
            'parent_id' => 'nullable|integer',
            'parent_type' => 'nullable|string',
        ]);

        // 获取被回复的评论或回复
        $parent = null;
        if ($request->has('parent_id') && $request->has('parent_type')) {
            if ($request->parent_type == 'comment') {
                $parent = CommentRestaurant::find($request->parent_id);
            } elseif ($request->parent_type == 'reply') {
                $parent = ReplyRestaurantComment::find($request->parent_id);
            }
        }

        $reply = new ReplyRestaurantComment();
        $reply->comment_id = $request->comment_id;
        $reply->user_id = Auth::id();
        $reply->name = Auth::user()->name;
        $reply->reply = $request->reply;

        // 设置 parent_id 和 parent_type
        if ($parent) {
            $reply->parent_id = $parent->id;
            $reply->parent_type = $request->parent_type;
            $reply->parent_name = $parent->user_name; // 使用 comment_restaurants 的 user_name
        }

        $reply->save();

        return back()->with('success', 'You have replied to this comment!');
    }

    public function deletereplyrestaurantcomment($id)
    {
        $reply = ReplyRestaurantComment::findOrFail($id);
        if ($reply->user_id == Auth::id()) {
            $reply->delete();
            return response()->json(['success' => true, 'message' => 'Reply deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'You can only delete your own replies.']);
    }

//-------------------------------------------------------- Resort Reple Comment Area ------------------------------------------------//

    public function replyresortcomment(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|integer',
            'reply' => 'required|string',
            'parent_id' => 'nullable|integer',
            'parent_type' => 'nullable|string',
        ]);

        // 获取被回复的评论或回复
        $parent = null;
        if ($request->has('parent_id') && $request->has('parent_type')) {
            if ($request->parent_type == 'comment') {
                $parent = CommentResort::find($request->parent_id);
            } elseif ($request->parent_type == 'reply') {
                $parent = ReplyResortComment::find($request->parent_id);
            }
        }

        $reply = new ReplyResortComment();
        $reply->comment_id = $request->comment_id;
        $reply->user_id = Auth::id();
        $reply->name = Auth::user()->name;
        $reply->reply = $request->reply;

        // 设置 parent_id 和 parent_type
        if ($parent) {
            $reply->parent_id = $parent->id;
            $reply->parent_type = $request->parent_type;
            $reply->parent_name = $parent->user_name; // 使用 comment_resorts 的 user_name
        }

        $reply->save();

        return back()->with('success', 'You have replied to this comment!');
    }

    public function deletereplyresortcomment($id)
    {
        $reply = ReplyResortComment::findOrFail($id);
        if ($reply->user_id == Auth::id()) {
            $reply->delete();
            return response()->json(['success' => true, 'message' => 'Reply deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'You can only delete your own replies.']);
    }

//-------------------------------------------------------- Resort Reple Comment Area ------------------------------------------------//

    public function replyhotelcomment(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|integer',
            'reply' => 'required|string',
            'parent_id' => 'nullable|integer',
            'parent_type' => 'nullable|string',
        ]);

        // 获取被回复的评论或回复
        $parent = null;
        if ($request->has('parent_id') && $request->has('parent_type')) {
            if ($request->parent_type == 'comment') {
                $parent = CommentHotel::find($request->parent_id);
            } elseif ($request->parent_type == 'reply') {
                $parent = ReplyHotelComment::find($request->parent_id);
            }
        }

        $reply = new ReplyHotelComment();
        $reply->comment_id = $request->comment_id;
        $reply->user_id = Auth::id();
        $reply->name = Auth::user()->name;
        $reply->reply = $request->reply;

        // 设置 parent_id 和 parent_type
        if ($parent) {
            $reply->parent_id = $parent->id;
            $reply->parent_type = $request->parent_type;
            $reply->parent_name = $parent->user_name; // 使用 comment_hotels 的 user_name
        }

        $reply->save();

        return back()->with('success', 'You have replied to this comment!');
    }

    public function deletereplyhotelcomment($id)
    {
        $reply = ReplyHotelComment::findOrFail($id);
        if ($reply->user_id == Auth::id()) {
            $reply->delete();
            return response()->json(['success' => true, 'message' => 'Reply deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'You can only delete your own replies.']);
    }

}
