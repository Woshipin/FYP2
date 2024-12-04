<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResortCommunityMultipleImage extends Model
{
    use HasFactory;

    protected $fillable = ['community_id', 'image_path'];

    // Define the relationship with the ResortCommunity model
    public function community()
    {
        return $this->belongsTo(ResortCommunity::class, 'community_id');
    }
}
