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
        Schema::create('tb_invkeluar', function (Blueprint $table) {
            $table->unsignedBigInteger('id_wo');
            $table->unsignedBigInteger('id_barang');
            $table->string('qty');

            
             $table->foreign('id_wo')
                ->references('id')->on('tb__wo')// refrensi diambil dari id yang ada pada tb kategori
                ->onUpdate('cascade') // Jika nama kategori diubah, foreign key tetap valid
                ->onDelete('restrict');// jika ada barang maka tidak bisa dihapus;

               $table->foreign('id_barang')
                ->references('id')->on('tb_barang')// refrensi diambil dari id yang ada pada tb kategori
                ->onUpdate('cascade') // Jika nama kategori diubah, foreign key tetap valid
                ->onDelete('restrict');// jika ada barang maka tidak bisa dihapus;


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
        Schema::dropIfExists('tb_invkeluar');
    }
};
