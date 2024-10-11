<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyResortComment extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(CommentResort::class, 'comment_id');
    }

    public function repliesToReplies()
    {
        return $this->hasMany(ReplyToReplyResortComment::class, 'reply_id');
    }
}
