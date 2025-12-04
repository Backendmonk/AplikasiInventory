<?php

namespace App\Http\Controllers;

use App\Models\Model_chartAkun;
use App\Models\ModelAlurStok;
use App\Models\ModelBarang;
use App\Models\ModelStok;
use Illuminate\Http\Request;

class ControllerStokAdmin extends Controller
{
    //

    public function JumlahStokBarangView(){
        $getdataStok=[

            'datastok'=>ModelStok::with('barangist')->get()
        ];

        return view('Admin.Stok.StokBarang',$getdataStok);
    }
    public function StokControllview( ){

       

         $gatdaatstokforalur = [

            'databarang' =>ModelBarang::where('Status','=','Aktif')->get()

        ];  

        return view('Admin.Stok.AlurStokbarang',$gatdaatstokforalur);


        
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

            return view('Admin.Stok.Alurstok',$GetAlldatabarang);

           
        }elseif($tools['opname'] != NULL){
                $GetData = [
                    'barang'=>ModelBarang::Where('id','=',$id)->first()
                ];

                return view('Admin.Stok.StokOpname',$GetData);
            

            
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
        $hpp = $opname_tbBarang['HargaBeli'];


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

        $idselisihpersediaan = Model_chartAkun::where('nama','=','Beban Selisih Persediaan')->first();
        $idpersediaanasset = Model_chartAkun::where('nama','=','Persediaan Asset')->first();
       $idpendapatan = Model_chartAkun::where('nama','=','Pendapatan Selisih Persediaan')->first();
       

        $selisihunit = $databarang['stokawal']-$databarang['stokupdate'];
        $selisihrupiah = abs($selisihunit*$hpp);

        $idref = 07+rand(99,10000);
        if ($databarang['stokupdate'] < $databarang['stokawal'] ) {
            # code...
            ControllerJurnal::catatanjurnal($idselisihpersediaan['id'],$selisihrupiah,0,$idref);
            ControllerJurnal::catatanjurnal( $idpersediaanasset['id'],0,$selisihrupiah,$idref);

            $updateslPersediaan = Model_chartAkun::find($idselisihpersediaan['id']);
            $updatePersediaanAsst = Model_chartAkun::find($idpersediaanasset['id']);

            $saldoSlPr = $updateslPersediaan['saldo']+$selisihrupiah;
            $saldoPR = $updatePersediaanAsst['saldo']+$selisihrupiah;

            $updatePersediaanAsst->fill([
                'saldo'=>$saldoPR
            ]);
            $updateslPersediaan->fill([
                'saldo'=>$saldoSlPr
            ]);
            $updatePersediaanAsst->save();
            $updatePersediaanAsst->save();


            //update harus
        }elseif ($databarang['stokupdate'] > $databarang['stokawal']) {
            # code...
               ControllerJurnal::catatanjurnal( $idpersediaanasset['id'],$selisihrupiah,0,$idref);
               ControllerJurnal::catatanjurnal($idpendapatan['id'],0,$selisihrupiah,$idref);

                $updatependapatanPers = Model_chartAkun::find($idpendapatan['id']);
                $updatePersediaanAsst = Model_chartAkun::find($idpersediaanasset['id']);

            $saldoPen = $updatependapatanPers['saldo']+$selisihrupiah;
            $saldoPR = $updatePersediaanAsst['saldo']+$selisihrupiah;

            $updatePersediaanAsst->fill([
                'saldo'=>$saldoPR
            ]);
            $updatependapatanPers->fill([
                'saldo'=>$saldoPen
            ]);
            $updatePersediaanAsst->save();
            $updatePersediaanAsst->save();
            
        }


        $opname_tbBarang ->save();
        $update_stok->save();
        $addAlur->save();


        return redirect()->route('stokcontrol')->with('msgdone','');
        
    }
}


