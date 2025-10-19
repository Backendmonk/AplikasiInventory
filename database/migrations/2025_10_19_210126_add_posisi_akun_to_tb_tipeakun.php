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
        Schema::table('tb_tipeakun', function (Blueprint $table) {
            //
             $table->enum('normal_balance', [
                'Debit',
                'Credit'
            ])->nullable(); // untuk posisi normal (optional)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_tipeakun', function (Blueprint $table) {
            //
        });
    }
};
