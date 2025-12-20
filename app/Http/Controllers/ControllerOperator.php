<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelOperator;
use Illuminate\Http\Request;

class ControllerOperator extends Controller
{
    //
    public function OperatorHome(){
        $operatorget = [
            'operator'=>ModelOperator::all()
        ];
        return view('Admin.Operator.operatorhome', $operatorget);
    }

    public function Operatoraddform(){
        return view('Admin.Operator.operatoradd');
    }
}
