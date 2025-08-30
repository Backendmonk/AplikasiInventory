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
