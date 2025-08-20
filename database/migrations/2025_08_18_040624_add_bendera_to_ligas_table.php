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
            Schema::table('ligas', function (Blueprint $table) {
                // Tambahkan kolom 'bendera' setelah kolom 'negara'
                $table->string('bendera')->nullable()->after('negara');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('ligas', function (Blueprint $table) {
                $table->dropColumn('bendera');
            });
        }
    };
    