<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelBarang extends Model
{
    use HasFactory;

    protected $table = 'tb_barang';

    protected $primaryKey = 'id';
    protected $fillable  = ['id','nama_barang','id_kategori','stok_barang','Status','HargaJual','HargaBeli'];

    public $timestamps = false;

    public $incrementing = true;


    //pilih hak milik kemana (belongs To) dari id_kategori

    public function Kategoribr(){
        return $this->belongsTo(ModelKategoriBarang::class,'id_kategori');
    }

    public function adabarangdiStok(){
        return $this->hasmany(ModelStok::class,'idbarang')
                    ->hasmany(ModelAlurStok::class,'idbarang');
                    
    }

    public function adadetailPO(){
        return $this->hasmany(ModelDetailPO::class,'id_barang');

    }
}
