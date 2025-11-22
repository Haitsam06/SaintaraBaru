<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_package_id',
        'nama',
        'kode',
    ];

    public function testPackage()
    {
        return $this->belongsTo(TestPackage::class);
    }

    public function peserta()
    {
        return $this->hasMany(PesertaTes::class);
    }
}
