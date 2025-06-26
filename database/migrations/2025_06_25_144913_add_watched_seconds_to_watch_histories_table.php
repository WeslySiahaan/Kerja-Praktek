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
        Schema::table('watch_histories', function (Blueprint $table) {
            // Ini akan menambahkan kolom 'watched_seconds' bertipe integer
            // dengan nilai default 0, dan posisinya setelah kolom 'progress'.
            $table->integer('watched_seconds')->default(0)->after('progress');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('watch_histories', function (Blueprint $table) {
            // Ini akan menghapus kolom 'watched_seconds' jika migrasi di-rollback.
            $table->dropColumn('watched_seconds');
        });
    }
};