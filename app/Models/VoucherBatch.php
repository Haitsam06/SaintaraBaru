<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'instansi_id',
        'kode',
        'tanggal',
        'jumlah',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
