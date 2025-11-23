<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id'); // user yang lapor
            $table->string('subject');
            $table->string('category');
            $table->text('description');
            $table->string('status')->default('pending'); // pending, on-progress, done
            $table->timestamps();
            $table->foreign('customer_id')->references('id_customer')->on('customers')->onDelete('cascade')->onUpdate('cascade');
        });
    }
};