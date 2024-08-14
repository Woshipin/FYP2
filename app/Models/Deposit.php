<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name', 'user_email', 'type_name', 'deposit_price', 'total_price',
        'card_number', 'card_holder', 'card_month', 'card_year', 'cvv'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
