<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelNotaPembelianBarang extends Model
{
    use HasFactory;

     protected $table = 'tb_nota_pembelian';
    protected $fillable  = ['id','id_pembelian','totalsemua'];

    public $timestamps = true;

    public $incrementing = false;

    
    public function pembelianBarang(){
        return $this->belongsTo(ModelPembelianBarang::class,'id_pembelian');
    }
}
