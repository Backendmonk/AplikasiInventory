<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPO extends Model
{
    use HasFactory;

    protected $table = 'tb_po';

    protected $primaryKey = 'id';
    protected $fillable  = ['id','total','keterangan'];

    public $timestamps = false;

    public $incrementing = true;

}
