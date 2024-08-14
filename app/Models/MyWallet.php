<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name', // 确保包含 user_name
        'profit',
        'balance',
        'refund_price',
        'refund_deposit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

