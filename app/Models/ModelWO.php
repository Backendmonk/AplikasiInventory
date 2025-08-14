<?php

namespace App\Models;

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
        'harga'];

    public $timestamps = false;

    public $incrementing = true;


      public function adadetailwo(){
        return $this->hasmany(ModelInvKeluar::class,'id_wo');

    }





}
