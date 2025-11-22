<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TesOrder extends Model
{
    protected $guarded = [];

    public function package()
    {
        return $this->belongsTo(TesPackage::class, 'package_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function result()
    {
        return $this->hasOne(TesResult::class, 'order_id');
    }
}