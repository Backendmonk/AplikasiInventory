<?php

namespace App\Http\Controllers;

use App\Models\Model_chartAkun;
use App\Models\Model_tipeakun;
use App\Models\MOdelJurnal;
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
                'tipe'=>$reqdatacoa->tipe, //ini adalah id dari tipe akun
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
        $keteranganPosisi = $selectdatatipeAkun['category']; //mengambil kategori akun
        $balanceakunNormal  = $selectdatatipeAkun['normal_balance'];
        
        /*
            input data ke table Chart Akun  
        */
        try {
            //code...
                 $inputtodb->fill([

            'id'=>$datacoa['id'],
            'id_tipeakun'=>$datacoa['tipe'], // ini adalah id dari tipe akun 
            'kode'=>$datacoa['kode_akun'],
            'nama'=>$datacoa['nama_akun'],
            'keterangan'=>$keteranganPosisi,
            'saldo_awal'=>$datacoa['saldoawal'],
            'tanggal_saldo_awal'=>$datacoa['tgl'],
            'saldo'=>$datacoa['saldoawal']
        ]);

        /*
             cek apakah Chart akun baru tersebut memiliki Opening balance atau saldo  ? jika iya maka 
             harus di inputkan kedalam jurnal, dimana ketika input kedalam jurnal yang harus dipanggil adalah 
             id dari COA Modal, kemudian simpan terlebiih dahulu COa baru. lalu cek apakah posisi akun coa baru
              adalah posisi normal di debit atau kredit

              lalu lakukan penginputan sesuai dengan posisi normal dari COA baru kemudaian di sesuaikan oleh MOdal


              Jika COA baru tidak memiliki opening balance maka COA hanya akan diinputkan ke Table COA
        */
        
        $randomNota = rand(500,100000);
        if ($datacoa['saldoawal'] > 0) {
             $cekidModal = Model_chartAkun::where('nama','=','Modal')->first();
             $idmodal = $cekidModal['id'];
               $inputtodb->save(); //input COa ke db dengan jurnal
            # code...
                if ($balanceakunNormal =="Debit") {
                ControllerJurnal::catatanjurnal($datacoa['id'],$datacoa['saldoawal'],0,$randomNota);
                ControllerJurnal::catatanjurnal( $idmodal,0,$datacoa['saldoawal'],$randomNota);
                }elseif ($balanceakunNormal =="Credit") {
                    # code...
                    ControllerJurnal::catatanjurnal($datacoa['id'],0,$datacoa['saldoawal'],$randomNota);
                    ControllerJurnal::catatanjurnal( $idmodal,$datacoa['saldoawal'],0,$randomNota);
                }else{
                    return redirect()->route('COAHome')->with('gagal','');
                }    
        }else{
            $inputtodb->save();//input COa ke db tanpa jurnal

        }

         
        
       
        return redirect()->route('COAHome')->with('msgdone','');
        } catch (\Throwable $th) {
            //throw $th;
             return redirect()->route('COAHome')->with('gagal','');
        }

       
    }


}
