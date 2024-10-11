<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyToReplyResortComment extends Model
{
    use HasFactory;

    protected $fillable = ['reply_id', 'user_id', 'name', 'reply'];

    public function reply()
    {
        return $this->belongsTo(ReplyResortComment::class, 'reply_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
