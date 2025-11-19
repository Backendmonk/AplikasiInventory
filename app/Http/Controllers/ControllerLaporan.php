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
}
