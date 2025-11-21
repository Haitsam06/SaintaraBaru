<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraitKarakter extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'nama',
        'deskripsi',
    ];

    public function peserta()
    {
        return $this->belongsToMany(PesertaTes::class, 'peserta_trait')->withTimestamps();
    }
}
