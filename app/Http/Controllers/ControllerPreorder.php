<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelBarang;
use Illuminate\Http\Request;

class ControllerPreorder extends Controller
{
    public function TambahPreorder(){

        $datPerlu = [

            'databarang'=> ModelBarang::all(),

        ];

            return view('Admin.PreOrder.TambahPreorder',$datPerlu);
        }

}
