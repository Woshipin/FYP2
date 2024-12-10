<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantCommunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'name',
        'image',
        'cultural',
        'address',
        'latitude',
        'longitude',
        'description',
        'category', // Added category to fillable fields
    ];

    // Relationship to the RestaurantCommunityMultipleImage model
    public function multipleImages()
    {
        return $this->hasMany(RestaurantCommunityMultipleImage::class, 'community_id');
    }
}
