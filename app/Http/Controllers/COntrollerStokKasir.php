<?php

namespace App\Http\Controllers;

use App\Models\ModelAlurStok;
use App\Models\ModelBarang;
use App\Models\ModelStok;
use Illuminate\Http\Request;

class COntrollerStokKasir extends Controller
{
    //
     public function JumlahStokBarangView(){
        $getdataStok=[

            'datastok'=>ModelStok::with('barangist')->get()
        ];

        return view('Kasir.Stok.StokBarang',$getdataStok);
    }
    public function StokControllview( ){

       

         $gatdaatstokforalur = [

            'databarang' =>ModelBarang::where('Status','=','Aktif')->get()

        ];  

        return view('Kasir.Stok.AlurStokbarang',$gatdaatstokforalur);


        
    }


    public function ToolsAlurStok(Request $reqdata ){
            $id = $reqdata->idbarang;

                    $tools = [

                    'alurstok'=>$reqdata->detail,
                    'opname'=>$reqdata->opname
                ];

        if($tools['alurstok'] != NULL){
             $GetAlldatabarang = [

                'databarang'=>ModelBarang::where('id','=',$id)->first(),
                'alurstok'=>ModelAlurStok::where('idbarang','=',$id)
                                            ->with('barangidAl')->get()
            ];

            return view('Kasir.Stok.Alurstok',$GetAlldatabarang);

           
        }elseif($tools['opname'] != NULL){
                $GetData = [
                    'barang'=>ModelBarang::Where('id','=',$id)->first()
                ];

                return view('Kasir.Stok.StokOpname',$GetData);
            

            
        }

           


    }



    public function OpnameStok(request $rqdataStokBarang){

        $id = $rqdataStokBarang ->id;
        $stokupdate = $rqdataStokBarang->stokaktual;

        $databarang = [

            'id' => $rqdataStokBarang ->id,
            'stokupdate' => $rqdataStokBarang->stokaktual,
            'stokawal'=> $rqdataStokBarang->stoksistem,
            'pesan'=>$rqdataStokBarang->pesan

        ];

        return $this->Prosesopname($databarang);

    }

    private function Prosesopname($databarang){

        //update tabel barang
        $opname_tbBarang  = ModelBarang::find($databarang['id']);
        $opname_tbBarang -> stok_barang = $databarang['stokupdate'];


        //update stok
        $date = date('Y-m-d');
        $update_stok= ModelStok::where('idbarang',$databarang['id'])->first();
        $update_stok ->stok = $databarang['stokupdate'];
        $update_stok ->pertanggal = $date;


        //
        $keterangan = 'Opname Stok';

        $addAlur   = new ModelAlurStok();
        $addAlur->fill([

            'idbarang'=>$databarang['id'],
            'Stok_Awal'=>$databarang['stokawal'],
            'Stok_Akhir'=> $databarang['stokupdate'],
            'keterangan'=> $keterangan,
            'pesan'=>$databarang['pesan']
            
        ]);


        $opname_tbBarang ->save();
        $update_stok->save();
        $addAlur->save();


        return redirect()->route('stokcontrol')->with('msgdone','');
        
    }
}
