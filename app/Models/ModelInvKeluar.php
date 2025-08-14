<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelInvKeluar extends Model
{
    use HasFactory;
    protected $table = 'tb_invkeluar';
    protected $fillable  = ['id_wo','id_barang','qty'];

    public $timestamps = false;

    public $incrementing = true;


      public function datawo(){
        return $this->belongsTo(ModelWO::class,'id_wo','id');
    }

      public function databarangwo(){
        return $this->belongsTo(ModelBarang::class,'id_barang','id');
    }



}
