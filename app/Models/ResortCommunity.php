<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResortCommunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'resort_id',
        'name',
        'image',
        'cultural',
        'address',
        'latitude',
        'longitude',
        'description',
        'category', // Added category to fillable fields
    ];

    // Relationship to the ResortCommunityMultipleImage model
    public function multipleImages()
    {
        return $this->hasMany(ResortCommunityMultipleImage::class, 'community_id');
    }
}
