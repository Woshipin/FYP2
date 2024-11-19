<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\FacilityIconMapper; // 导入类

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'charge_type',
        'is_active',
        'display_order'
    ];

    protected $appends = ['icon_class'];

    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }

    public function getIconClassAttribute()
    {
        return FacilityIconMapper::getIcon($this->name);
    }
}
