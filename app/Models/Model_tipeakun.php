<?php

namespace App\Models;

use Database\Seeders\ChartOfAccountsSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model_tipeakun extends Model
{
    use HasFactory;

     protected $table = 'tb_tipeakun';
    protected $fillable = ['code', 'nama_code', 'category', 'normal_balance'];
    
    public $timestamps = true;

    public $incrementing = true;

      public function kodeakun(){
        return $this->hasmany(Model_chartAkun::class,'id_tipeakun');

    }

  
}
