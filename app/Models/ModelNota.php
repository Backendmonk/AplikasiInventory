<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelNota extends Model
{
    use HasFactory;
    protected $table = 'tb__nota';

    //protected $primaryKey = 'id';
    protected $fillable  = ['nonota','nomorwo','barang','qty','Harga','total','created_at','updated_at'];

    public $timestamps = false;



      public function Modelwor(){
        return $this->belongsTo(ModelWO::class,'id_wo');
    }
    
     public function pembayaran()
{
    return $this->belongsTo(ModelPembayaranNota::class, 'nomorwo', 'idwo');
}


 
    
}
