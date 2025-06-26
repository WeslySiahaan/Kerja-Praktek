// database/migrations/YYYY_MM_DD_HHMMSS_create_watch_histories_table.php

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
        Schema::create('watch_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_id')->nullable()->constrained()->onDelete('set null'); // <-- PENTING: Untuk menghubungkan ke video
            $table->string('title');
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Path gambar poster
            $table->integer('progress')->default(0); // Progress tontonan (0-100)
            $table->string('watched_time')->nullable(); // Durasi tontonan, misal '00:30 / 12:35'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('watch_histories', function (Blueprint $table) {
       $table->foreignId('video_id')->nullable()->constrained()->onDelete('set null')->after('user_id');
});
    }
};