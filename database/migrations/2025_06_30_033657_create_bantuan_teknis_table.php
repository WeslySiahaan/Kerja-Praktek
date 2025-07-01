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
        Schema::create('bantuan_teknis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('jawaban')->nullable();
            $table->timestamps();
        });

        // Tambahkan 3 data awal langsung
        DB::table('bantuan_teknis')->insert([
            [
                'judul' => 'Masalah Login',
                'jawaban' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Kesalahan Aplikasi',
                'jawaban' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Panduan Penggunaan',
                'jawaban' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bantuan_teknis');
    }
};
