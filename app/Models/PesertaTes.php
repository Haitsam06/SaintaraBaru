<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaTes extends Model
{
    use HasFactory;

    protected $table = 'peserta_tes';

    protected $fillable = [
        'golongan_id',
        'test_package_id',
        'instansi_id',
        'tipe_akun',
        'nama_lengkap',
        'nama_panggilan',
        'email',
        'no_telp',
        'negara',
        'kota',
        'golongan_darah',
        'jenis_kelamin',
        'devisi',
        'tanggal_lahir', 
        'status',
    ];

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function traits()
    {
        return $this->belongsToMany(TraitKarakter::class, 'peserta_trait')
                    ->withTimestamps();
    }
}
