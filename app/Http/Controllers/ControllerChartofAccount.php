<?php

namespace App\Http\Controllers;

use App\Models\Model_chartAkun;
use App\Models\Model_tipeakun;
use Illuminate\Http\Request;

class ControllerChartofAccount extends Controller
{
    //

    public function Coadashboard(){

        $selectdata = [

            'dataCOA'=>Model_chartAkun::with('tipeakun')->get(),
        ];


        return view('Admin.ChartOfAccount.CoADashboard',$selectdata);
    }

    public function COAaddView(){

        $datatipeakun = [

            'tipeakun' => Model_tipeakun::all(),
        ];

        return view('Admin.ChartOfAccount.CoaViewadd',$datatipeakun);
    }


    public function CoaAdd(Request $reqdatacoa ){

        $datacoa = [
                'id'=>$reqdatacoa->id,
                'tipe'=>$reqdatacoa->tipe,
                'nama_akun'=>$reqdatacoa->nama_akun,
                'kode_akun'=>$reqdatacoa->kode_akun,
                'saldoawal'=>$reqdatacoa->saldoawal,
                'tgl'=>$reqdatacoa->tgl


        ];
        return $this->PushCOaTodb($datacoa);

    }

    private function PushCOaTodb($datacoa){

        $inputtodb  = New Model_chartAkun();
        $selectdatatipeAkun = Model_tipeakun::where('id','=',$datacoa['tipe'])->first();
        $keteranganPosisi = $selectdatatipeAkun['category'];

        try {
            //code...
                 $inputtodb->fill([

            'id'=>$datacoa['id'],
            'id_tipeakun'=>$datacoa['tipe'],
            'kode'=>$datacoa['kode_akun'],
            'nama'=>$datacoa['nama_akun'],
            'keterangan'=>$keteranganPosisi,
            'saldo_awal'=>$datacoa['saldoawal'],
            'tanggal_saldo_awal'=>$datacoa['tgl'],
            'saldo'=>$datacoa['saldoawal']
            

        ]);


        $inputtodb->save();
        return redirect()->route('COAHome')->with('msgdone','');
        } catch (\Throwable $th) {
            //throw $th;
             return redirect()->route('COAHome')->with('gagal','');
        }

       
    }


}
