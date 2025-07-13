<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelAlurStok extends Model
{
    use HasFactory;
        protected $table = 'tb_alur_stok';

    protected $primaryKey = 'id';
    protected $fillable  = ['id','idbarang','Stok_Awal','Stok_Akhir','keterangan'];

    public $timestamps = true;

    public $incrementing = true;


     public function barangidAl(){
        return $this->belongsTo(ModelBarang::class,'idbarang');
    }
}
