<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Model_chartAkun;
use App\Models\MOdelMetodeBayar;
use Illuminate\Http\Request;

class ControllerPayment extends Controller
{
    //

    public function Homepayment(){

        $varpayment = [

            'datapayment'=>MOdelMetodeBayar::with('metodebayar')->get(),
        ];

        return view('Admin.Payment.Homepayment',$varpayment);

    }

    public function Paymentaddform(){

        $getdatacoa = [
            'datacoa'=>Model_chartAkun::where('keterangan','=','Kas dan Bank')->get()
        ];
        return view('Admin.Payment.PaymentForm',$getdatacoa);
    }


    public function Paymentadd(request $requestData){

        //belum
        $datapayment =[

            'namapayment'=>$requestData->namapayment,
            'kategori'=>$requestData->kategoripayment
        ];


        return $this->inputpaymenttotb($datapayment);
    }


    private function inputpaymenttotb($datapayment){

        $namapayment = $datapayment['namapayment'];
        $kategoriCOA = $datapayment['kategori'];


        $inputtodb = new MOdelMetodeBayar();

        try {
            //code...
            $inputtodb->fill([

                'nama_metode'=>$namapayment,
                'idcoa'=>$kategoriCOA

              
            ]);
              $inputtodb->save();
                return redirect()->route('payment')->with('msgdone','');
        } catch (\Throwable $th) {
            //throw $th;
             return redirect()->route('payment')->with('gagal','');
        }
    }
}
