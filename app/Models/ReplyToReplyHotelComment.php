<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyToReplyHotelComment extends Model
{
    use HasFactory;

    protected $fillable = ['reply_id', 'user_id', 'name', 'reply', 'parent_id', 'parent_type', 'parent_name'];

    public function reply()
    {
        return $this->belongsTo(ReplyHotelComment::class, 'reply_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
