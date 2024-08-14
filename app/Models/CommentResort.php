<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentResort extends Model
{
    use HasFactory;

    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
    	return $this->hasMany(ReplyResortComment::class);
    }
}
