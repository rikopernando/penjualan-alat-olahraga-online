<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoTelponAlamatProvinsiDllFieldProduks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->longText('alamat')->nullable();
          $table->string('no_telp')->nullable();
          $table->string('provinsi')->nullable();
          $table->string('kabupaten')->nullable();
          $table->string('kecamatan')->nullable();
          $table->string('kelurahan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('alamat');
          $table->dropColumn('no_telp');
          $table->dropColumn('provinsi');
          $table->dropColumn('kabupaten');
          $table->dropColumn('kecamatan');
          $table->dropColumn('kelurahan');
        });
    }
}
