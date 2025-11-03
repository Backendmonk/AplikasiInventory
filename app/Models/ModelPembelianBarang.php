<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPembelianBarang extends Model
{
    use HasFactory;

      protected $table = 'tb_nota_pembelian';
    protected $fillable  = ['id','id_barang','harga_pembelian','suplier','qty'];

    public $timestamps = true;

    public $incrementing = false;


}
