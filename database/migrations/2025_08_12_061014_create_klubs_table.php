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
       Schema::create('klubs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kota');
            $table->string('stadion');
            $table->string('logo')->nullable(); // nullable berarti boleh kosong
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klubs');
    }
};
