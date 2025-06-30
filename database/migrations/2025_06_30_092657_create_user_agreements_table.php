<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAgreementsTable extends Migration
{
    public function up()
    {
        Schema::create('user_agreements', function (Blueprint $table) {
            $table->id();
            $table->text('ketentuan_umum')->nullable();
            $table->text('hak_kekayaan_intelektual')->nullable();
            $table->text('akun_pengguna')->nullable();
            $table->text('pembatasan_tanggung_jawab')->nullable();
            $table->text('penghentian_layanan')->nullable();
            $table->text('kontak')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_agreements');
    }
}
