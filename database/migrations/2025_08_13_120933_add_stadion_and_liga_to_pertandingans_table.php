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
    Schema::table('pertandingans', function (Blueprint $table) {
        $table->string('stadion')->after('tanggal_pertandingan')->nullable();
        $table->string('liga')->after('stadion')->nullable();
    });
}

public function down(): void
{
    Schema::table('pertandingans', function (Blueprint $table) {
        $table->dropColumn(['stadion', 'liga']);
    });
}
};
