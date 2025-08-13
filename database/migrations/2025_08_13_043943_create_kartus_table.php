<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kartus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pertandingan_id')->constrained()->onDelete('cascade');
            $table->foreignId('pemain_id')->constrained()->onDelete('cascade');
            $table->enum('jenis_kartu', ['kuning', 'merah']);
            $table->integer('menit_kartu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kartus');
    }
};