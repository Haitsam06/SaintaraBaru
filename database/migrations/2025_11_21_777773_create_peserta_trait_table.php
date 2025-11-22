<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta_trait', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peserta_tes_id')
                  ->constrained('peserta_tes')
                  ->cascadeOnDelete();

            $table->foreignId('trait_karakter_id')
                  ->constrained('trait_karakters')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_trait');
    }
};
