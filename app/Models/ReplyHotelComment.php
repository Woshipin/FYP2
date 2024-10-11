<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyHotelComment extends Model
{
    use HasFactory;

    protected $fillable = ['comment_hotel_id', 'user_id', 'name', 'reply', 'parent_id', 'parent_type', 'parent_name'];

    public function commentHotel()
    {
        return $this->belongsTo(CommentHotel::class, 'comment_hotel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function repliesToReplies()
    {
        return $this->hasMany(ReplyToReplyHotelComment::class, 'reply_id');
    }
}
