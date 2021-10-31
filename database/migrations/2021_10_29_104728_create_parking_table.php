<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parkings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_tiket')->unique();
            $table->string('jenis_kendaraan');
            $table->string('plat_no');
            $table->string('plat_no_1');
            $table->string('plat_no_2');
            $table->string('plat_no_3');
            $table->string('durasi');
            $table->double('tarif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parkings');
    }
}
