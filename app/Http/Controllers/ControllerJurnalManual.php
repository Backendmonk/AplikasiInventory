<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Builder\Function_;

class ControllerJurnalManual extends Controller
{
    //

    public function JurnalManual(){
        return view('Admin.JurnalManual.Home');

        
    }
}
