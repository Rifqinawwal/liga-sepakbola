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
    Schema::table('klubs', function (Blueprint $table) {
        $table->foreignId('liga_id')->nullable()->after('stadion')->constrained('ligas')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('klubs', function (Blueprint $table) {
        $table->dropForeign(['liga_id']);
        $table->dropColumn('liga_id');
    });
}
};
