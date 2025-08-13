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
        Schema::create('pertandingans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klub_tuan_rumah_id')->constrained('klubs');
            $table->foreignId('klub_tamu_id')->constrained('klubs');
            $table->date('tanggal_pertandingan');
            $table->integer('skor_tuan_rumah')->nullable();
            $table->integer('skor_tamu')->nullable();
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertandingans');
    }
};
