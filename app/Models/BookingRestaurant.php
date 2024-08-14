<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRestaurant extends Model
{
    use HasFactory;

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    // public function deposit()
    // {
    //     return $this->belongsTo(Deposit::class);
    // }

    public function deposit()
    {
        return $this->hasOne(Deposit::class, 'card_number', 'card_number')->where('cvv', $this->cvv);
    }

}
