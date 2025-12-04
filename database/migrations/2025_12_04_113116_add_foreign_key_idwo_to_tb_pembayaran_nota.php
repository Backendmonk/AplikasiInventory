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
        Schema::table('tb_pembayaran_nota', function (Blueprint $table) {
            //
               $table->foreign('idwo')
                ->references('id')
                ->on('tb__wo') // referensi ke tabel tb_wo
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
        Schema::table('tb_pembayaran_nota', function (Blueprint $table) {
            //
        });
    }
};
