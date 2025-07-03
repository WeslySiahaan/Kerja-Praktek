<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recommendation_user_saves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recommendation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Pastikan kombinasi unik antara recommendation_id dan user_id
            $table->unique(['recommendation_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('recommendation_user_saves');
    }
};