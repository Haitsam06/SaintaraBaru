<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'token_cost',
        'type',
    ];

    public function golongans()
    {
        return $this->hasMany(Golongan::class);
    }
}
