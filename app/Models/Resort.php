<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resort extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'price', 'phone', 'email', 'type', 'country', 'state', 'location', 'description',
    'latitude','longitude','map','digital_lock_password','emailbox_password'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(CommentResort::class);
    }

    public function replies()
    {
        return $this->hasMany(ReplyResortComment::class);
    }

    public function bookings()
    {
        return $this->hasMany(BookingResort::class, 'resort_id', 'name');
    }

    public function ratings()
    {
        return $this->morphMany(ResortRating::class, 'rateable');
    }

    // Mutliple Image Model
    public function images()
    {
        return $this->hasMany(ResortImage::class);
    }

    // Define a method to generate the booking URL
    public function getURL()
    {
        // Adjust this according to your actual URL generation logic
        return route('bookingresort', ['id' => $this->id]); // Assuming you have a route named 'restaurant.booking'
    }

    public function promotionDates()
    {
        return $this->hasMany(resort_promotion_dates::class);
    }

    public function getPromotionDatesWithPrices()
    {
        return $this->promotionDates()
            ->select('date', 'price')
            ->get();
    }

    public function discounts()
    {
        return $this->hasMany(ResortDiscount::class);
    }

}
