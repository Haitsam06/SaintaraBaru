<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'instansi_id',
        'nama',
        'email',
        'devisi',
        'tgl_tes',
        'karakter',
    ];

    protected $casts = [
        'tgl_tes' => 'date',
    ];
}
