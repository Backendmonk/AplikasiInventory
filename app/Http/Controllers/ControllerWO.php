<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerWO extends Controller
{
    //


    public function Wodashboard(){

        return view ('Admin.Workorder.Wodashboard');
    }   
}
