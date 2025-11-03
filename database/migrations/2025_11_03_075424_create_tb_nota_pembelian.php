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
        Schema::create('tb_nota_pembelian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pembelian');
            $table->string('totalsemua');
            $table->timestamps();

             $table->foreign('id_pembelian')->references('id')->on('tb_pembelian_barang')// refrensi diambil dari id yang ada pada tb Barang
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
        Schema::dropIfExists('tb_nota_pembelian');
    }
};
