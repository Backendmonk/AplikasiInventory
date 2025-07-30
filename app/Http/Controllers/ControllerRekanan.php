<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelRekanan;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;

class ControllerRekanan extends Controller
{
    //

    public function RekananView(){

        $datarekan = [
            'rekanan'=>ModelRekanan::all()
        ];

        return view('Admin.Rekanan.DataRekanan',$datarekan);
    }

    public function TambahRekananView(){


        return view('Admin.Rekanan.TambahRekanan');
    }
     public function Addrekanan( request $reqdataRekananBaru){

            $rekanan = [
                'id'=>$reqdataRekananBaru->id,
                'nama_rekanan'=>$reqdataRekananBaru->rekanan,
                'alamat'=>$reqdataRekananBaru->alamat
            ];


            return $this->ProsesAddRekanan($rekanan);
     }


     private function ProsesAddRekanan($rekanan){

        $prosesAdd = New ModelRekanan();

        try {
            //code...

             $prosesAdd -> fill([
            'id' => $rekanan['id'],
            'nama_rekanan' =>$rekanan['nama_rekanan'],
            'alamat_rekanan' => $rekanan['alamat']


        ]);

                $prosesAdd->save();
        return redirect()->route('rekanan')->with('msgdone','');
        } catch (\Throwable $th) {
            //throw $th;

            return redirect()->route('rekanan')->with('gagal','');
            
        }
       

     }
}
