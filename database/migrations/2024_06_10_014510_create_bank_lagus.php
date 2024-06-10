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
        Schema::create('bank_lagus', function (Blueprint $table) {
            $table->id();
            $table->enum('source', ['upload', 'scanner'])->default('upload');
            $table->string('title');
            $table->string('artist');
            $table->string('country');
            $table->string('genre');
            $table->string('year');
            $table->string('path');
            $table->string('filename');
            $table->bigInteger('total_play')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_lagus');
    }
};
