<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelBarang extends Model
{
    use HasFactory;

    protected $table = 'tb_barang';

    protected $primaryKey = 'id';
    protected $fillable  = ['id','nama_barang','id_kategori','stok_barang'];

    public $timestamps = false;

    public $incrementing = true;


    //pilih hak milik kemana (belongs To) dari id_kategori

    public function Kategoribr(){
        return $this->belongsTo(ModelKategoriBarang::class,'id_kategori');
    }
}
