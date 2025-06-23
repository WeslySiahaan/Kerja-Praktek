<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopularsTable extends Migration
{
    public function up()
    {
        Schema::create('populars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('category');
            $table->string('poster');
            $table->string('trailer');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('populars');
    }
}
