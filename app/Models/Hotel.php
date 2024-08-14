<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'image', 'phone', 'email', 'type', 'country', 'state', 'address','latitude','longitude',
    'map','description','digital_lock_password','emailbox_password'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function rooms() {
        return $this->hasMany(Room::class);
    }

    public function comments()
    {
        return $this->hasMany(CommentHotel::class);
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function images()
    {
        return $this->hasMany(HotelImage::class);
    }

    // Define a method to generate the booking URL
    public function getURL()
    {
        // Adjust this according to your actual URL generation logic
        return route('bookinghotel', ['id' => $this->id]); // Assuming you have a route named 'restaurant.booking'
    }

}
