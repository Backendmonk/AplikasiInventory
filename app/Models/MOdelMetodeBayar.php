<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MOdelMetodeBayar extends Model
{
    use HasFactory;

      protected $table = 'tb_metodepembayaran';
    protected $fillable = ['id','nama_metode','idcoa'];
    
    public $timestamps = true;

    public $incrementing = true;


      public function metodebayar(){
        return $this->belongsTo(Model_chartAkun::class,'idcoa');
    }

    public function historybayar(){
      
        return $this->hasMany(ModelHistoryPembayaran::class,'id_paymentmethod');
    }

    public function historypembelian(){
      
        return $this->hasMany(ModelHistoryPembelianBarang::class,'id_payment');
    }


}
