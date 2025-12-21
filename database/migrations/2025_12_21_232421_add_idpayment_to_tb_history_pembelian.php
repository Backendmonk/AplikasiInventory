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
        Schema::table('tb_history_nota_pembelian', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('id_payment')->after('id_nota_pembelian');
            $table->foreign('id_payment')
                ->references('id')->on('tb_metodepembayaran')// refrensi diambil dari id yang ada pada tb kategori
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
        Schema::table('tb_history_pembelian', function (Blueprint $table) {
            //
        });
    }
};
