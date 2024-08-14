<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminWallet extends Model
{
    use HasFactory;

    protected $fillable = ['type_id','type_name','type_category','user_deposit', 'tax', 'balance', 'transferred_status'];
}

