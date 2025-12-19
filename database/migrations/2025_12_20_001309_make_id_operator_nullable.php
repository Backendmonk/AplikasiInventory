<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            DB::statement("
           ALTER TABLE tb__wo
                MODIFY id_operatorcetak BIGINT UNSIGNED NULL,
                MODIFY id_operatorpotong BIGINT UNSIGNED NULL,
                MODIFY id_operatorproduksi BIGINT UNSIGNED NULL
                ");
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
