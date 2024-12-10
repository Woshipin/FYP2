<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantCommunityMultipleImage extends Model
{
    use HasFactory;

    protected $fillable = ['community_id', 'image_path'];

    // Define the relationship with the RestaurantCommunity model
    public function community()
    {
        return $this->belongsTo(RestaurantCommunity::class, 'community_id');
    }

    // Accessor for full image path
    public function getFullImagePathAttribute()
    {
        // 如果路径已经包含 "images/"，直接返回完整路径
        if (strpos($this->image_path, 'images/') !== false) {
            return asset($this->image_path);
        }

        // 否则拼接 "images/" 文件夹路径
        return asset('images/' . $this->image_path);
    }
}
