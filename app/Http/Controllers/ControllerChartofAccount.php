<?php

namespace App\Http\Controllers;

use App\Models\Model_chartAkun;
use App\Models\Model_tipeakun;
use App\Models\MOdelJurnal;
use Carbon\Carbon;
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
             $cekidSaldo = Model_chartAkun::where('nama','=','Saldo Awal')->first();
                          
         
            if ($cekidSaldo !== NULL) {
                $idSaldo = $cekidSaldo['id']; 
                 $inputtodb->save(); //input COa ke db dengan jurnal

                 $dataSaldoAwalJurnal = ['id'=>$idSaldo,
                 'saldo'=>$datacoa['saldoawal']
                 ];
                
                if ($balanceakunNormal =="Debit") {
                ControllerJurnal::catatanjurnal($datacoa['id'],$datacoa['saldoawal'],0,$randomNota);
                ControllerJurnal::catatanjurnal( $idSaldo,0,$datacoa['saldoawal'],$randomNota);
                
                return $this->UpdateSaldoAwal($dataSaldoAwalJurnal); //untuk mengupdate dan menambahkan saldo awal
                
                }elseif ($balanceakunNormal =="Credit") {
                    # code...
                    ControllerJurnal::catatanjurnal($datacoa['id'],0,$datacoa['saldoawal'],$randomNota);
                    ControllerJurnal::catatanjurnal( $idSaldo,$datacoa['saldoawal'],0,$randomNota);
                    return $this->UpdateSaldoAwal($dataSaldoAwalJurnal);//untuk mengupdate dan menambahkan saldo awal
                }else{
                    return redirect()->route('COAHome')->with('gagal','');
                }    
            }else{
                    $inputSaldoAwal  = New Model_chartAkun();
                    $now = Carbon::now();
                      $inputSaldoAwal->fill([

                            'id'=>"9992",
                            'id_tipeakun'=>"15", // ini adalah id dari tipe akun 
                            'kode'=>"01999",
                            'nama'=>"Saldo Awal",
                            'keterangan'=>"Equity",
                            'saldo_awal'=>"0",
                            'tanggal_saldo_awal'=>$now,
                            'saldo'=>"0"
                      ]);
                      $inputSaldoAwal->save();

                 return redirect()->route('COAHome')->with('gagalCOA','');

            }
                
        }else{
            $inputtodb->save();//input COa ke db tanpa jurnal
            return redirect()->route('COAHome')->with('msgdone','');
        }
        } catch (\Throwable $th) {
            //throw $th;
             return redirect()->route('COAHome')->with('gagal','');
        }

       
    }



    private function UpdateSaldoAwal($dataSaldoAwalJurnal){

        $saldoawalId= $dataSaldoAwalJurnal['id'];
        $saldoawal = $dataSaldoAwalJurnal['saldo'];

        $ambilsaldosekarang = Model_chartAkun::where('id','=',$saldoawalId)->first();
        $saldosekarang = $ambilsaldosekarang['saldo'];

        $saldoUpdated = $saldosekarang + $saldoawal;

        $updateSaldoawal = Model_chartAkun::find($saldoawalId);
        
        $updateSaldoawal->fill([

                'saldo' =>$saldoUpdated
        ]);

        $updateSaldoawal->save();

         return redirect()->route('COAHome')->with('msgdone','');
    }

    public function SaldoAwal(Request $reqSaldoAwal){

        $idcoa = $reqSaldoAwal->idbarang;
        $selectdataCOA = Model_chartAkun::where('id','=',$idcoa)->first();

        $dataView = [
            'dataCOA'=>$selectdataCOA
        ];

        return view('Admin.ChartOfAccount.CoaSaldoAwal',$dataView);
    }


    //udpdate nant
     public function SimpanSaldoAwal(request $reqdataSA){


        $getidCOA =  $reqdataSA->coaid;

        $getSaldo = Model_chartAkun::where('id',$getidCOA);

        $saldo = $getSaldo->saldo;

        $SA = 0  ;
        

     }

}
