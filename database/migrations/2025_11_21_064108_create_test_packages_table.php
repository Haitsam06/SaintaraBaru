<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_packages', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('token_cost');
            $table->enum('type', ['personal', 'team', 'gift']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_packages');
    }
};
