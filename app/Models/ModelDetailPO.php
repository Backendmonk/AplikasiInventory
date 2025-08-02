<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelDetailPO extends Model
{
    use HasFactory;

    protected $table = 'tb_po_detail';
    protected $fillable  = ['id_po','id_rekanan','id_barang','qty','status','catatan'];

    public $timestamps = false;

    public $incrementing = true;


    
    public function fpo(){
        return $this->belongsTo(ModelPO::class,'id_po');
    }

    public function frekanan(){
        return $this->belongsTo(ModelStok::class,'id_rekanan');
    }

        public function fbarang(){
        return $this->belongsTo(ModelStok::class,'id_barang');
    }




}
