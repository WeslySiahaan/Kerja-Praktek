<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('layanan_pelanggan', function (Blueprint $table) {
            $table->id();
            $table->text('kontak')->nullable();
            $table->text('pertanyaan')->nullable();
            $table->text('bantuan')->nullable();
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_pelanggan');
    }
};

