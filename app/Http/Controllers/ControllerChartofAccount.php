<?php

namespace App\Http\Controllers;

use App\Models\Model_chartAkun;
use Illuminate\Http\Request;

class ControllerChartofAccount extends Controller
{
    //

    public function Coadashboard(){

        $selectdata = [

            'dataCOA'=>Model_chartAkun::all(),
        ];


        return view('Admin.ChartOfAccount.CoADashboard');
    }


}
