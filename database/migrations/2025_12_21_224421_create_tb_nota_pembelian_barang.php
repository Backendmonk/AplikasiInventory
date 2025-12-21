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
        Schema::create('tb_nota_pembelian_barang', function (Blueprint $table) {
            $table->id();
            $table->string('total');
            $table->string('dibayar');
            $table->string('sisa');
            $table->string('catatan')->nullable(true);
            $table->string('status_nota');
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
        Schema::dropIfExists('tb_nota_pembelian_barang');
    }
};
