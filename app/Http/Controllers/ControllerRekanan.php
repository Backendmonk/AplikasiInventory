<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelRekanan;
use Illuminate\Http\Request;

class ControllerRekanan extends Controller
{
    //

    public function RekananView(){

        $datarekan = [
            'rekanan'=>ModelRekanan::all()
        ];

        return view('Admin.Rekanan.DataRekanan',$datarekan);
    }
}
