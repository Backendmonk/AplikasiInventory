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
            $table->unsignedBigInteger('id_nota_pembelian');
            $table->string('jumlah_beli');
            $table->string('harga_beli');
            $table->string('subtotal_harga_beli');

            $table->timestamps();


             $table->foreign('id_barang')
                ->references('id')->on('tb_barang')// refrensi diambil dari id yang ada pada tb kategori
                ->onUpdate('cascade') // Jika nama kategori diubah, foreign key tetap valid
                ->onDelete('restrict');// jika ada barang maka tidak bisa dihapus;


                 $table->foreign('id_nota_pembelian')
                ->references('id')->on('tb_nota_pembelian_barang')// refrensi diambil dari id yang ada pada tb kategori
                ->onUpdate('cascade') // Jika nama kategori diubah, foreign key tetap valid
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
