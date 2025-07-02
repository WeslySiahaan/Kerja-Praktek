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
        Schema::create('saran_masukan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');           // Nama pengirim
            $table->string('email');          // Email pengirim
            $table->text('pesan');            // Isi saran/masukan
            $table->timestamps();             // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saran_masukan');
    }
};
