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
        Schema::create('pemains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klub_id')->constrained()->onDelete('cascade');
            $table->string('nama_pemain');
            $table->string('posisi');
            $table->integer('nomor_punggung');
            $table->string('foto')->nullable(); // <-- TAMBAHKAN BARIS INI
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemains');
    }
};
