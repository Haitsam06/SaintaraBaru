<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'instansis';
    protected $primaryKey = 'id_instansi';

    // kalau pakai increment big int unsigned (default) tidak perlu diubah
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_instansi',
        'no_instansi',
        'nama_owner',
        'no_telp',
        'website',
        'email',
        'alamat_instansi',
    ];
}
