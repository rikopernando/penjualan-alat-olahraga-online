<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdProdukKomentar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('komentar_produks', function (Blueprint $table) {
            $table->integer('produk_id')->after('pelanggan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('komentar_produks', function (Blueprint $table) {
            $table->dropColumn('produk_id');
        });
    }
}
