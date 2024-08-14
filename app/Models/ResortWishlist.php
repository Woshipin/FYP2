<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResortWishlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'resort_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }
}
