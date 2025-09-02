<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelNota extends Model
{
    use HasFactory;
    protected $table = 'tb__nota';

    //protected $primaryKey = 'id';
    protected $fillable  = ['nonota','nomorwo','barang','qty','Harga','total'];

    public $timestamps = true;

    public $incrementing = true;


      public function Modelwor(){
        return $this->belongsTo(ModelWO::class,'id_wo');
    }
}
