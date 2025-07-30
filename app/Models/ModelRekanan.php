<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelRekanan extends Model
{
    use HasFactory;

    

    protected $table = 'tb_rekanan';

    protected $primaryKey = 'id';
    protected $fillable  = ['id','nama_rekanan','alamat_rekanan'];

    public $timestamps = false;

    public $incrementing = true;


}
