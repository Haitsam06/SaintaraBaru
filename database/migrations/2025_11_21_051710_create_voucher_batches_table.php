<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voucher_batches', function (Blueprint $table) {
            $table->id();

            // FK ke instansis (pk = id_instansi)
            $table->unsignedBigInteger('instansi_id');
            $table->string('kode');
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->string('status'); // misal: 'Sudah Dibuat', 'Digunakan', dll

            $table->timestamps();

            $table->foreign('instansi_id')
                ->references('id_instansi')
                ->on('instansis')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('voucher_batches', function (Blueprint $table) {
            $table->dropForeign(['instansi_id']);
        });

        Schema::dropIfExists('voucher_batches');
    }
};
