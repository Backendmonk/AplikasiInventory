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
        Schema::create('tb_pembelian_barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang');
            $table->string('harga_pembelian');
            $table->string('suplier');
            $table->string('qty');
            $table->string('total');
            $table->timestamps();


            $table->foreign('id_barang')->references('id')->on('tb_barang')// refrensi diambil dari id yang ada pada tb Barang
                ->onUpdate('cascade') // Jika nama Barang diubah, foreign key tetap valid
                ->onDelete('restrict');// jika ada barang maka tidak bisa dihapus;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_pembelian_barang');
    }
};
