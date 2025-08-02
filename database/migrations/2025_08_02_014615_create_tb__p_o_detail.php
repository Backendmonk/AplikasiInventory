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
        Schema::create('tb__p_o_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('id_po');
            $table->unsignedBigInteger('id_rekanan');
            $table->unsignedBigInteger('id_barang');
            $table->string('qty');
            $table->string('status');
            $table->string('catatan');



             $table->foreign('id_po')
                ->references('id')->on('tb_po')// refrensi diambil dari id yang ada pada tb kategori
                ->onUpdate('cascade') // Jika nama kategori diubah, foreign key tetap valid
                ->onDelete('restrict');// jika ada barang maka tidak bisa dihapus;

                $table->foreign('id_rekanan')
                ->references('id')->on('tb_rekanan')// refrensi diambil dari id yang ada pada tb kategori
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
        Schema::dropIfExists('tb__p_o_detail');
    }
};
