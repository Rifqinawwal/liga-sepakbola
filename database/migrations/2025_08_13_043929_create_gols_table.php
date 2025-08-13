<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gols', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pertandingan_id')->constrained()->onDelete('cascade');
            $table->foreignId('pemain_id')->constrained()->onDelete('cascade'); // Pencetak gol
            $table->foreignId('assist_pemain_id')->nullable()->constrained('pemains')->onDelete('set null'); // Pemberi assist (bisa kosong)
            $table->integer('menit_gol');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gols');
    }
};