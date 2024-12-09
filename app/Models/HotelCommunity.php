<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelCommunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'name',
        'image',
        'cultural',
        'address',
        'latitude',
        'longitude',
        'description',
        'category', // Added category to fillable fields
    ];

    // Relationship to the HotelCommunityMutlipleImage model
    public function multipleImages()
    {
        return $this->hasMany(HotelCommunityMutlipleImage::class, 'community_id');
    }
}
