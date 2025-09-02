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
        Schema::create('tb__nota', function (Blueprint $table) {
            $table->integer('nonota');
            $table->unsignedBigInteger('nomorwo');
            $table->string('barang');
            $table->string('qty');
            $table->string('Harga');
            $table->string('total');
            $table->timestamps();

             $table->foreign('nomorwo')
                ->references('id')->on('tb__wo')// refrensi diambil dari id yang ada pada tb kategori
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
        Schema::dropIfExists('tb__nota');
    }
};
