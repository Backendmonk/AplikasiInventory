<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerPreorder extends Controller
{
    public function TambahPreorder(){

            return view('Admin.PreOrder.TambahPreorder');
        }

}
