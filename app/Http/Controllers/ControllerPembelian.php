<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Model_chartAkun;
use App\Models\ModelBarang;
use App\Models\MOdelMetodeBayar;
use App\Models\ModelNotaPembelianBarang;
use App\Models\ModelPembelianBarang;
use Illuminate\Http\Request;

class ControllerPembelian extends Controller
{
    //
    public function PembelianView(){

        $getpembelian = [

            'pembelianbarang'=>ModelPembelianBarang::with('notaPembelian')->with('barangBeli')->get(),
        ];
        return view('Admin.Pembelian.pembelianbarang',$getpembelian);
    }


    public function pembeliantambah(){

        $data = 
        [

            'databarang'=>ModelBarang::all(),
            'datametodebayar'=>MOdelMetodeBayar::all()
        ];
        return view('Admin.Pembelian.tambahpembelian',$data);
    }


    public function ProsesPembelian(Request $reqdata ){

        $datareq = $reqdata->all();
         return $this->TambahNotaHandle($datareq);
    }

    private function TambahNotaHandle($datareq){

        $inputnota = new ModelNotaPembelianBarang();

        //cek saldo kas pada COA
            $idKasbank = $datareq['metodebayar'];
            $rdm = rand(1000,9999);

                $cekidCOA = ModelMetodeBayar::find($idKasbank);
                $ceksaldo  = Model_chartAkun::where('id',$cekidCOA->idcoa)->first();
                $idkasbannk = $ceksaldo->id;

                $cekhutang = Model_chartAkun::where('nama','Hutang Usaha')->first();
                $idhutang = $cekhutang->id;

                $cekpersediaanAsset = Model_chartAkun::where('nama','Persediaan Asset')->first();
                $idpersediaan = $cekpersediaanAsset->id;

            if ($ceksaldo->saldo < $datareq['deposit']) {
                
                return redirect()->route('PembelianBarang')->with('error',' ');
            }else{

                 $sisa = $datareq['total']-$datareq['deposit'];
                        if ($sisa > 0) {
                                $status = 'Hutang';
                                ControllerJurnal::catatanjurnal($idpersediaan,$datareq['total'],0,'NotaPB-'.$rdm);
                                ControllerJurnal::catatanjurnal($idhutang,0,$sisa,'NotaPB-'.$rdm);
                                ControllerJurnal::catatanjurnal($idkasbannk,0,$datareq['deposit'],'NotaPB-'.$rdm);

                                //updates coa

                                $upPersediaan = Model_chartAkun::find($idpersediaan);
                                $uphutang = Model_chartAkun::find($idhutang);
                                $upkasbank  = Model_chartAkun::find($idkasbannk);

                                $persediaanSaldo = $upPersediaan->saldo + $datareq['total'];
                                $hutangsaldo = $uphutang->saldo + $sisa;
                                $kasbanksaldo = $upkasbank->saldo - $datareq['deposit'];

                                $upPersediaan->saldo = $persediaanSaldo;
                                $uphutang->saldo = $hutangsaldo;    
                                $upkasbank->saldo = $kasbanksaldo;
                                $upPersediaan->save();
                                $uphutang->save();
                                $upkasbank->save();
                                //Tambahkan  history Transaksi




                            }elseif ($sisa == 0) {
                                $status = 'Selesai';
                                 ControllerJurnal::catatanjurnal($idpersediaan,$datareq['total'],0,'NotaPB-'.$rdm);
                                ControllerJurnal::catatanjurnal($idkasbannk,0,$datareq['deposit'],'NotaPB-'.$rdm);

                                //updates coa

                                $upPersediaan = Model_chartAkun::find($idpersediaan);
                                $upkasbank  = Model_chartAkun::find($idkasbannk);

                                $persediaanSaldo = $upPersediaan->saldo + $datareq['total'];
                                $kasbanksaldo = $upkasbank->saldo - $datareq['deposit'];
                                $upPersediaan->saldo = $persediaanSaldo;
                                $upkasbank->saldo = $kasbanksaldo;
                                $upPersediaan->save();
                                $upkasbank->save();



                            }
                        $inputnota->fill([

                            'total'=>$datareq['total'],
                            'dibayar'=>$datareq['deposit'],
                            'sisa'=> $sisa,
                            'catatan'=>$datareq['catatan'],
                            'status_nota'=>$status,
                            
                        ])->save();

                         return $this->TambahItemPembelianHandle($datareq,$inputnota->id);
            }
       
       
        
    }


    private function TambahItemPembelianHandle($datareq,$notaid){

       

        try {
            //code...

             foreach ($datareq['barang'] as $key => $value) {
            
            $inputitem = new ModelPembelianBarang();
            $inputitem->fill([

                'id_barang'=>$datareq['barang'][$key],
                'id_nota_pembelian'=>$notaid,
                'suplier_nama'=>$datareq['supplier_nama'],
                'jumlah'=>$datareq['jumlah'][$key],
                'harga_beli'=>$datareq['harga_beli'][$key],
                'subtotal_harga_beli'=>$datareq['subtotal'][$key],
                'createrd_at'=>$datareq['tanggal_pembelian']


            ])->save();
        }
        return  $this->updatedatabarang($datareq['barang'],$datareq['jumlah']);

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->with('error','Gagal Menambahkan Pembelian Barang');
        }
       
}

        private function updatedatabarang($databarang,$datajumlah){

            foreach ($databarang as $key => $value) {
                
                $getbarang = ModelBarang::where('id',$databarang[$key])->first();

                $newstok = $getbarang->stok + $datajumlah[$key];

                ModelBarang::where('id',$databarang[$key])->update([

                    'stok'=>$newstok
                ]);
            }

            return redirect('/Admin/Pembelian')->with('success','Berhasil Menambahkan Pembelian Barang');
        }
}

