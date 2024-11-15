<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resort_promotion_dates extends Model
{
    use HasFactory;

    protected $fillable = ['resort_id', 'date'];

    protected $dates = ['date'];

    // 添加日期转换
    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }
}
