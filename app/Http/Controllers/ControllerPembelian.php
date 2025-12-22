<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelBarang;
use App\Models\MOdelMetodeBayar;
use App\Models\ModelPembelianBarang;
use Illuminate\Http\Request;

class ControllerPembelian extends Controller
{
    //
    public function PembelianView(){

        $getpembelian = [

            'pembelianbarang'=>ModelPembelianBarang::with('notaPembelian')->with('barangBeli')->get(),
        ];
        return view('Admin.Pembelian.pembelianbarang',$getpembelian);
    }


    public function pembeliantambah(){

        $data = 
        [

            'databarang'=>ModelBarang::all(),
            'datametodebayar'=>MOdelMetodeBayar::all()
        ];
        return view('Admin.Pembelian.tambahpembelian',$data);
    }
}
