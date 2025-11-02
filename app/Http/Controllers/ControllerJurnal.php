<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MOdelJurnal;
use Illuminate\Http\Request;

class ControllerJurnal extends Controller
{
    //

    public static function catatanjurnal ($id_akun, $debit = 0 , $kredit = 0 ,$idnota=null){
        $inputtojurnal =new MOdelJurnal();
        $inputtojurnal->fill([
            'id_akun'=>$id_akun,
            'debit'=>$debit,
            'kredit'=>$kredit,
            'idnota'=>$idnota,
         ]);

             $inputtojurnal->save();
         

     

    }
}
