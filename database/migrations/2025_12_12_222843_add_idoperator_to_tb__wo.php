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
        Schema::table('tb__wo', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('id_operatorcetak');
            $table->unsignedBigInteger('id_operatorpotong');
            $table->unsignedBigInteger('id_operatorproduksi');


            $table->foreign('id_operatorcetak')
                ->references('id')
                ->on('tb_operator') // referensi ke tabel tb_wo
                ->onUpdate('cascade')  // jika id wo berubah, ikut berubah
                ->onDelete('restrict'); // kalau ada pembayaran, WO tidak bisa dihapus

                 $table->foreign('id_operatorpotong')
                ->references('id')
                ->on('tb_operator') // referensi ke tabel tb_wo
                ->onUpdate('cascade')  // jika id wo berubah, ikut berubah
                ->onDelete('restrict'); // kalau ada pembayaran, WO tidak bisa dihapus

                 $table->foreign('id_operatorproduksi')
                ->references('id')
                ->on('tb_operator') // referensi ke tabel tb_wo
                ->onUpdate('cascade')  // jika id wo berubah, ikut berubah
                ->onDelete('restrict'); // kalau ada pembayaran, WO tidak bisa dihapus

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb__wo', function (Blueprint $table) {
            //
        });
    }
};
