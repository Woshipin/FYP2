<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyHotelComment extends Model
{
    use HasFactory;

    public function comment()
    {
        return $this->belongsTo(CommentHotel::class, 'comment_id');
    }
}
