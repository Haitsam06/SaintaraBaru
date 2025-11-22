<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TesPackage extends Model
{
    protected $guarded = [];
    protected $casts = [
        'features' => 'array',
    ];

    public function orders()
    {
        return $this->hasMany(TesOrder::class, 'package_id');
    }
}
