<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHistoryPembayaran extends Model
{
    use HasFactory;

    
    protected $table = 'tb_history_pembayaran';
    protected $fillable  = ['idNota','totalbayar','dibayarkan','sisa','pertanggal','id_paymentmethod'];

    public $timestamps = false;

    public $incrementing = false;

      public function metodebayarhs(){
      return $this->belongsTo(MOdelMetodeBayar::class,'id_paymentmethod');
    }
}
