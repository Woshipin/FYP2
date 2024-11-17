<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResortDiscount extends Model
{
    use HasFactory;

    protected $fillable = ['resort_id', 'nights', 'discount'];

    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }
    
}
