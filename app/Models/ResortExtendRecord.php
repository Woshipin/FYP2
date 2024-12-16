<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResortExtendRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_resort_id',
        'checkin_date',
        'checkout_date',
        'extend_dates',
        'payment_information',
    ];

    protected $casts = [
        'extend_dates' => 'array',
        'payment_information' => 'array',
    ];

    public function bookingResort()
    {
        return $this->belongsTo(BookingResort::class);
    }
}

