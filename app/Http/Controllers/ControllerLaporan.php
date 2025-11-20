<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerLaporan extends Controller
{
    //

    public function LaporanHome(){

        return View('Admin.Laporan.Home');
    }


    public function Jurnalselected(){

        $tipeselected = ['selected'=>'Jurnal'];

        return view('Admin.Laporan.Rentangtanggal',$tipeselected);
    }

     public function Labarugiselected(){

        $tipeselected = ['selected'=>'Laba-Rugi'];

        return view('Admin.Laporan.Rentangtanggal',$tipeselected);
    }

     public function Neracaselected(){

        $tipeselected = ['selected'=>'Neraca'];

        return view('Admin.Laporan.Rentangtanggal',$tipeselected);
    }
}
