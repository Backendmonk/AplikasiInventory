<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelPembelianBarang;
use Illuminate\Http\Request;

class ControllerPembelian extends Controller
{
    //
    public function PembelianView(){

        $getpembelian = [

            'pembelianbarang'=>ModelPembelianBarang::with('notaPembelian')->get(),
        ];
        return view('Admin.Pembelian.pembelianbarang',$getpembelian);
    }
}
