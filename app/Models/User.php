<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // 设置默认值
        static::creating(function ($user) {
            $user->status = $user->status ?? 0;
        });
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function resorts()
    {
        return $this->hasMany(Resort::class);
    }

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function tables()
    {
        return $this->hasManyThrough(Table::class, Restaurant::class);
    }

    public function bookings()
    {
        return $this->hasMany(BookingRestaurant::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function contact()
    {
        return $this->hasMany(Contact::class);
    }

    public function usercontact()
    {
        return $this->hasMany(UserContact::class);
    }

    public function deposit()
    {
        return $this->hasMany(Deposit::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function bookedRestaurants()
    {
        return $this->hasMany(BookingRestaurant::class);
    }

    public function bookingHotels()
    {
        return $this->hasMany(BookingHotel::class, 'user_id');
    }

    public function bookingResorts()
    {
        return $this->hasMany(BookingResort::class, 'user_id');
    }

    public function bookingRestaurants()
    {
        return $this->hasMany(BookingRestaurant::class, 'user_id');
    }

    public function wishlist()
    {
        return $this->hasMany(HotelWishlist::class);
    }

    public function resortwishlist()
    {
        return $this->hasMany(ResortWishlist::class);
    }

    public function restaurantwishlist()
    {
        return $this->hasMany(RestaurantWishlist::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function faceRecognition()
    {
        return $this->hasOne(FaceRecognition::class);
    }

}
