<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','name', 'image','phone', 'email','type','country', 'state', 'date','time','address','description',
    'latitude','longitude','map'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function comments()
    {
        return $this->hasMany(CommentRestaurant::class);
    }

    public function ratings()
    {
        return $this->morphMany(RestaurantRating::class, 'rateable');
    }

    public function images()
    {
        return $this->hasMany(RestaurantImage::class);
    }

    // Define a method to generate the booking URL
    public function getURL()
    {
        // Adjust this according to your actual URL generation logic
        return route('bookingrestaurant', ['id' => $this->id]); // Assuming you have a route named 'restaurant.booking'
    }

}
