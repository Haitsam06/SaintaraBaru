<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trait_karakters', function (Blueprint $table) {
            $table->id(); // bigint unsigned
            $table->string('slug')->unique();   // pemarah, pemalu, introvert, extrovert
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trait_karakters');
    }
};
