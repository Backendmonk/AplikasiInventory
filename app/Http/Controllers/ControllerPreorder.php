<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelBarang;
use App\Models\ModelRekanan;
use Illuminate\Http\Request;

class ControllerPreorder extends Controller
{
    public function TambahPreorder(){

        $datPerlu = [

            'databarang'=> ModelBarang::all(),
            'dataRekanan'=>ModelRekanan::all()

        ];

            return view('Admin.PreOrder.TambahPreorder',$datPerlu);
        }

    public function ProsesPO(request $reqDataPO){

        $dataPO = [
                'id'=>$reqDataPO->idrek,
                'pesan'=>$reqDataPO->pesan,
                'item'=>$reqDataPO->items


        ];

        return $this->TambahPOKeDB($dataPO);

    }

    private function TambahPOKeDB($dataPO){

        $id = $dataPO['id'];

        $pesan = $dataPO['pesan'];

        $items = $dataPO['item'];
        $i = 0;

        foreach ($items as $item) {
            
            
        }
    }

}
