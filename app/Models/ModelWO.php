<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelWO extends Model
{
    use HasFactory;


     protected $table = 'tb__wo';

    protected $primaryKey = 'id';
    protected $fillable  = ['diterimaTanggal',
        'selesaiTanggal',
        'nama_pesanan',
        'jenis_pesanan',
        'jumlah_pesanan',
        'jumlah_kertasdicetak',
        'jenis_kertas',
        'warna_tinta',
        'ukuran_cetak',
        'ukuran_jadi',
        'ukuran_rangkapsusun',
        'reproduksi',
        'sistemjilid',
        'statusorder',
        'plat',
        'nomoratorstart',
        'warnatinta',
        'isiperbuku',
        'harga','status','keterangan',
        'id_operatorcetak',
        'id_operatorpotong',
        'id_operatorproduksi'
    ];

    public $timestamps = false;

    public $incrementing = true;


      public function adadetailwo(){
        return $this->hasmany(ModelInvKeluar::class,'id_wo');

    }

       public function adawodinota(){
        return $this->hasmany(ModelNota::class,'id_wo');

    }

           public function woinpbnota(){
        return $this->hasmany(ModelPembayaranNota::class,'idwo');

    }

    public function wocetak(){
        return $this->belongsTo(ModelOperator::class,'id_operatorcetak','id');

    }

     public function wopotong(){
        return $this->belongsTo(ModelOperator::class,'id_operatorpotong','id');

    }

      public function woproduksi(){
        return $this->belongsTo(ModelOperator::class,'id_operatorproduksi','id');

    }
}
