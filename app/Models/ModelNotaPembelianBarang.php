<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelNotaPembelianBarang extends Model
{
    use HasFactory;
    protected $table = 'tb_nota_pembelian_barang';
    protected $fillable = [
        'id',
        'total',
        'dibayar',
        'sisa',
        'catatan',
        'status_nota',
    ];

    public $timestamps = true;
    public $incrementing = false;

    public function pembelianBarang(){
        return $this->hasmany(ModelPembelianBarang::class,'id_nota_pembelian','id');
    }

    public function historyPembelian(){
        return $this->hasmany(ModelHistoryPembelianBarang::class,'id_nota_pembelian','id');
    }

}
