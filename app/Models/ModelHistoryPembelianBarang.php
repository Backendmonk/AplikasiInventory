<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHistoryPembelianBarang extends Model
{
    use HasFactory;
    protected $table = 'tb_history_nota_pembelian';
    protected $fillable = [
        'id_nota_pembelian',
        'totalbayar',
        'dibayar',
        'sisa',
        'id_payment',
    ];
    public $timestamps = true;

    public $incrementing = false;

    public function notaPembelian(){
        return $this->belongsTo(ModelNotaPembelianBarang::class,'id_nota_pembelian','id');
    }

    public function metodePayment(){
        return $this->belongsTo(ModelMetodeBayar::class,'id_payment','id');
    }

}
