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
            'datacoa'=>Model_chartAkun::all()
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

        
    }
}
