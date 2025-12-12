<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelOperator extends Model
{
    use HasFactory;
    protected $table = 'tb_operator';
    protected $fillable = [
        'nama_operator',
    ];
    
    public $timestamps = true;
    public $incrementing = true;


    public function wocetak(){
        return $this->hasmany(ModelWO::class,'id_operatorcetak');

    }

     public function wopotong(){
        return $this->hasmany(ModelWO::class,'id_operatorpotong');

    }

      public function woproduksi(){
        return $this->hasmany(ModelWO::class,'id_operatorproduksi');

    }


}
