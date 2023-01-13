<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_pemilih', function (Blueprint $table) {
            $table->id();
            $table->string("dpid",25);
            $table->string("nkk",16);
            $table->string("nik",16)->unique();
            $table->string("nama");
            $table->string("tempat_lahir");
            $table->string("tgl_lahir");
            $table->enum("jenis_kelamin",['L','P']);
            $table->enum('status',['B','S','P']);
            $table->text('alamat');
            $table->string('rt',3);
            $table->string('rw',3);
            $table->string('disabilitas',3);
            $table->string('tps',3);
            $table->string('kd_kab',25);
            $table->string('kd_kec',25);
            $table->string('kd_kel',25);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_pemilih');
    }
};
