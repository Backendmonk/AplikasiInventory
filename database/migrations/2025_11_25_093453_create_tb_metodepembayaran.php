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
        Schema::create('tb_metodepembayaran', function (Blueprint $table) {
            $table->id();

            $table->string('nama_metode');
            $table->unsignedBigInteger('idcoa');
            


            $table->timestamps();

            $table->foreign('idcoa')
                ->references('id')->on('tb_chart_akun')// refrensi diambil dari id yang ada pada tb COA
                ->onUpdate('cascade') // Jika nama COA diubah, foreign key tetap valid
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
        Schema::dropIfExists('tb_metodepembayaran');
    }
};
