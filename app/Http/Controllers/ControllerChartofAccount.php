<?php

namespace App\Http\Controllers;

use App\Models\Model_chartAkun;
use App\Models\Model_tipeakun;
use Illuminate\Http\Request;

class ControllerChartofAccount extends Controller
{
    //

    public function Coadashboard(){

        $selectdata = [

            'dataCOA'=>Model_chartAkun::with('tipeakun')->get(),
        ];


        return view('Admin.ChartOfAccount.CoADashboard',$selectdata);
    }

    public function COAaddView(){

        $datatipeakun = [

            'tipeakun' => Model_tipeakun::all(),
        ];

        return view('Admin.ChartOfAccount.CoaViewadd',$datatipeakun);
    }


    public function CoaAdd(Request $reqdatacoa ){

        $datacoa = [
                

        ];

    }


}
