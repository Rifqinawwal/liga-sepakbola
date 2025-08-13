<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pergantians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pertandingan_id')->constrained()->onDelete('cascade');
            $table->foreignId('pemain_masuk_id')->constrained('pemains')->onDelete('cascade');
            $table->foreignId('pemain_keluar_id')->constrained('pemains')->onDelete('cascade');
            $table->integer('menit_pergantian');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pergantians');
    }
};