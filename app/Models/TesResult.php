<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TesResult extends Model
{
    protected $guarded = [];
    protected $casts = [
        'result_json' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(TesOrder::class, 'order_id');
    }
}
