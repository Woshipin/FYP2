<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResortRating extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'rateable_id', 'rateable_name', 'rateable_type', 'rating'];

    // public function rateable()
    // {
    //     return $this->morphTo();
    // }

    public function rateable()
    {
        return $this->morphTo('rateable', 'rateable_type', 'rateable_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

