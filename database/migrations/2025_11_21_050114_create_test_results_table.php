<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();

            // Kolom FK ke tabel instansis (id_instansi = PK)
            $table->unsignedBigInteger('instansi_id');

            // Data hasil tes
            $table->string('nama');
            $table->string('email');
            $table->string('devisi')->nullable();
            $table->date('tgl_tes');
            $table->string('karakter')->nullable();

            $table->timestamps();

            // Definisi foreign key
            $table->foreign('instansi_id')
                ->references('id_instansi')   // PK di tabel instansis
                ->on('instansis')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            // drop FK dulu supaya aman di beberapa versi MySQL
            $table->dropForeign(['instansi_id']);
        });

        Schema::dropIfExists('test_results');
    }
};
