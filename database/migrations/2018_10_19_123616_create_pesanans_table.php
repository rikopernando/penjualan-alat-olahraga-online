<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pelanggan_id');
            $table->integer('total');
            $table->string('metode_pembayaran');
            $table->integer('status_pesanan')->comment("0 = pesanan masuk atau baru, 1 = pesanan telah dikonfirmasi, 2 = pesanan sedang diproses, 3 = pesanan telah selesai, 4 = pesanan batal");
            $table->text('alasan_batal')->nullable();
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('pesanans');
    }
}
