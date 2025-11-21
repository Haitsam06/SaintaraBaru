<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peserta_tes', function (Blueprint $table) {
            // Tambah hanya kalau belum ada (kalau takut duplikat, kamu bisa cek dulu di DB)
            if (!Schema::hasColumn('peserta_tes', 'golongan_id')) {
                $table->foreignId('golongan_id')
                    ->nullable()
                    ->constrained('golongans')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('peserta_tes', 'test_package_id')) {
                $table->foreignId('test_package_id')
                    ->nullable()
                    ->constrained('test_packages')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('peserta_tes', 'instansi_id')) {
                $table->unsignedBigInteger('instansi_id')->nullable();
            }

            if (!Schema::hasColumn('peserta_tes', 'tipe_akun')) {
                $table->string('tipe_akun')->nullable();
            }

            if (!Schema::hasColumn('peserta_tes', 'nama_lengkap')) {
                $table->string('nama_lengkap')->nullable();
            }

            if (!Schema::hasColumn('peserta_tes', 'nama_panggilan')) {
                $table->string('nama_panggilan')->nullable();
            }

            if (!Schema::hasColumn('peserta_tes', 'email')) {
                $table->string('email')->nullable();
            }

            if (!Schema::hasColumn('peserta_tes', 'no_telp')) {
                $table->string('no_telp')->nullable();
            }

            if (!Schema::hasColumn('peserta_tes', 'negara')) {
                $table->string('negara')->nullable();
            }

            if (!Schema::hasColumn('peserta_tes', 'kota')) {
                $table->string('kota')->nullable();
            }

            if (!Schema::hasColumn('peserta_tes', 'golongan_darah')) {
                $table->string('golongan_darah', 5)->nullable();
            }

            if (!Schema::hasColumn('peserta_tes', 'jenis_kelamin')) {
                $table->string('jenis_kelamin', 20)->nullable();
            }

            if (!Schema::hasColumn('peserta_tes', 'devisi')) {
                $table->string('devisi')->nullable();
            }

            if (!Schema::hasColumn('peserta_tes', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable();
            }

            if (!Schema::hasColumn('peserta_tes', 'status')) {
                $table->string('status')->default('belum');
            }
        });
    }

    public function down(): void
    {
        Schema::table('peserta_tes', function (Blueprint $table) {
            $table->dropForeign(['golongan_id']);
            $table->dropForeign(['test_package_id']);
            $table->dropColumn([
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
            ]);
        });
    }
};
