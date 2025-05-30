<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerAuthUser extends Controller
{
    

    public function DirrectLoginNonUser(){

        return view('welcome');
    }

    public function UseraddBackend(){

        return view('registerAdmin');
    }
}
