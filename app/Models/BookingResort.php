<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingResort extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'user_name', 'resort_id', 'resort_name', 'gender', 'quantity',
        'checkin_date', 'checkout_date', 'booking_days', 'checkin_time', 'checkout_time',
        'deposit_price', 'total_price', 'card_number', 'card_holder', 'card_month', 'card_year', 'cvv'
    ];

    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function deposit()
    {
        return $this->hasOne(Deposit::class, 'card_number', 'card_number')->where('cvv', $this->cvv);
    }
}


