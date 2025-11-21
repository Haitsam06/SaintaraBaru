<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta_tes', function (Blueprint $table) {
            $table->id();

            // kalau kamu sudah punya tabel golongans dan mau relasi, aktifkan ini:
            $table->foreignId('golongan_id')->nullable()->constrained('golongans')->nullOnDelete();

            $table->enum('tipe_akun', ['personal', 'team'])->default('personal');
            $table->string('nama_lengkap');
            $table->string('nama_panggilan')->nullable();
            $table->string('email')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('negara')->nullable();
            $table->string('kota')->nullable();

            // BIODATA TES (langsung dibuat di sini, jadi tidak perlu migration add_biodata)
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('golongan_darah', 3)->nullable(); // A, B, AB, O

            $table->string('status')->default('belum');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_tes');
    }
};
