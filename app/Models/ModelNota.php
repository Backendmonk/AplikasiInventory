<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelNota extends Model
{
    use HasFactory;

    protected $table = 'tb__nota';

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'nonota',
        'nomorwo',
        'barang',
        'qty',
        'Harga',
        'total',
        'created_at',
        'updated_at'
    ];

    public function workorder()
    {
        return $this->belongsTo(ModelWO::class, 'nomorwo', 'id');
    }

    public function pembayaran()
    {
        return $this->belongsTo(ModelPembayaranNota::class, 'nonota', 'id');
    }
}
