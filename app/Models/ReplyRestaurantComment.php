<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyRestaurantComment extends Model
{
    use HasFactory;

    public function comment()
    {
        return $this->belongsTo(CommentRestaurant::class, 'comment_id');
    }
}
