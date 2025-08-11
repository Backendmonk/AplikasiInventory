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
        Schema::create('tb__wo', function (Blueprint $table) {
            $table->id();
            $table->date('diterimaTanggal')->nullable();
            $table->date('selesaitanggal')->nullable();
            $table->string('nama_pesanan')->nullable();
            $table->string('jenis_pesanan')->nullable();
            $table->string('jumlah_pesanan')->nullable();
            $table->string('jumlah_kertasdicetak')->nullable();
            $table->string('jenis_kertas')->nullable();
            $table->string('warna_tinta')->nullable();
             $table->string('ukuran_cetak')->nullable();
              $table->string('ukuran_jadi')->nullable();
              $table->string('ukuran_rangkapsusun')->nullable();
                $table->string('reproduksi')->nullable();
                $table->string('sistemjilid')->nullable();
                $table->string('statusorder')->nullable();
                $table->string('plat')->nullable();
                 $table->string('nomoratorstart')->nullable();
                  $table->string('warnatinta')->nullable();
                   $table->string('isiperbuku')->nullable();  
                   $table->string('harga')->nullable();

                $table->string('status');



                
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
        Schema::dropIfExists('tb__wo');
    }
};
