<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelKategoriBarang extends Model
{
    use HasFactory;
    


    protected $table = 'tb__kategori__barang__admin';

    protected $primaryKey = 'id';
    protected $fillable  = ['id','Kategori'];

    public $timestamps = false;

    public $incrementing = true;




    /// pada tabel barang ada banyak Kategori Has many

    public function barangAdm(){
        // return saat memanggil fungsi barangadm dimana daman model barang ada banyak id kategori
        return $this->hasMany(ModelBarang::class,'id_kategori');
    }
}
