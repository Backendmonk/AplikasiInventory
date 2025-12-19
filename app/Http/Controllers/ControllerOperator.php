<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerOperator extends Controller
{
    //
    public function OperatorHome(){
        return view('Admin.Operator.operatorhome');
    }
}
