<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Model_chartAkun;
use App\Models\ModelAlurStok;
use App\Models\ModelBarang;
use App\Models\ModelHistoryPembelianBarang;
use App\Models\MOdelMetodeBayar;
use App\Models\ModelNotaPembelianBarang;
use App\Models\ModelPembelianBarang;
use App\Models\ModelStok;
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
            $id = rand(1000,9999);

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
                                ControllerJurnal::catatanjurnal($idpersediaan,$datareq['total'],0,$id);
                                ControllerJurnal::catatanjurnal($idhutang,0,$sisa,$id);
                                ControllerJurnal::catatanjurnal($idkasbannk,0,$datareq['deposit'],$id);

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
                                 ControllerJurnal::catatanjurnal($idpersediaan,$datareq['total'],0,$id);
                                ControllerJurnal::catatanjurnal($idkasbannk,0,$datareq['deposit'],$id);

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

                            'id'=>$id,
                            'total'=>$datareq['total'],
                            'dibayar'=>$datareq['deposit'],
                            'sisa'=> $sisa,
                            'catatan'=>$datareq['catatan'],
                            'status_nota'=>$status,
                            
                        ])->save();


                        $inputhistoryTransaksi = New ModelHistoryPembelianBarang();
                        $inputhistoryTransaksi->fill([

                            'id_nota_pembelian'=>$id,
                            'id_payment'=>$datareq['metodebayar'],
                            'totalbayar'=>$datareq['total'],
                            'dibayar'=>$datareq['deposit'],
                            'sisa'=>$sisa,
                        ])->save();
                         return $this->TambahItemPembelianHandle($datareq,$id);
            }
       
       
        
    }


    private function TambahItemPembelianHandle($datareq,$notaid){

       

        try {

    foreach ($datareq['items'] as $item) {

        ModelPembelianBarang::create([
            'id_barang' => $item['barang'],
            'id_nota_pembelian' => $notaid,
            'suplier_nama' => $datareq['supplier_nama'],
            'jumlah_beli' => $item['jumlah'],
            'harga_beli' => $item['harga_beli'],
            'subtotal_harga_beli' => $item['subtotal'],
            'created_at' => $datareq['tanggal_pembelian'],
        ]);
        }

        return $this->updatedatabarang(
            array_column($datareq['items'], 'barang'),
            array_column($datareq['items'], 'jumlah')
        );

    } catch (\Throwable $th) {
        dd($th->getMessage());
    }

       
}

      private function updatedatabarang($databarang, $datajumlah)
{
    foreach ($databarang as $key => $idbarang) {

        $getbarang = ModelBarang::find($idbarang);
        if (!$getbarang) continue;

        $stokAwal = $getbarang->stok_barang;
        $jumlahBeli = $datajumlah[$key];

        $stokAkhir = $stokAwal + $jumlahBeli;

        // update stok barang
        $getbarang->update([
            'stok_barang' => $stokAkhir
        ]);

        // simpan alur stok
        ModelAlurStok::create([
            'idbarang'  => $idbarang,
            'keterangan' => 'Pembelian Barang',
            'Stok_Awal'  => $stokAwal,
            'Stok_Akhir' => $stokAkhir,
            'pesan'      => 'Menambahkan Stok dari Pembelian Barang',
        ]);
    }

    $modelstok = ModelStok::where('idbarang', $databarang)->first();

      $pertanggal = date('y-m-d');
                         $modelstok->fill([
                            'idbarang'=>$idbarang,
                            'stok'=>$stokAkhir,
                            'pertanggal'=>$pertanggal

                         ])->save();

    return redirect('/Admin/Pembelian')
        ->with('msgdone', '');
}



public function DetailPembelian(Request $reqdata){

    
        $pelunasan = $reqdata->pelunasan;
        $detail = $reqdata->detail;
        $history = $reqdata->history;
        $id = $reqdata->idnota;
        if ($pelunasan != NULL) {
            # code...   
            $pem = ['pembelianbarang'=>ModelPembelianBarang::where('id_nota_pembelian','=',$id)->with('notaPembelian')->with('barangBeli')->get(),
                'MetodeBayar'=>MOdelMetodeBayar::all(),
        ];

            return view('Admin.Pembelian.pelunasanpembelian',$pem);
        }
        elseif ($detail !=NULL) {
            # code...
        $pem = ['pembelianbarang'=>ModelPembelianBarang::where('id_nota_pembelian','=',$id)->with('notaPembelian')->with('barangBeli')->get(),];
         
           return view('Admin.Pembelian.detailpembelian',$pem);
        }
        elseif ($history !=NULL) {
            # code...
            $pem = ['historypembelian'=>ModelHistoryPembelianBarang::where('id_nota_pembelian','=',$id)->with('notaPembelian')->with('metodePayment')->get(),];
              return view('Admin.Pembelian.historypembelian',$pem);
        }
}


public function PelunasanHutang(Request $reqdata){

        $datareq = $reqdata->all();
         return $this->PelunasanHutangHandle($datareq);
    }


private function PelunasanHutangHandle($datareq){

        $idnota = $datareq['id_nota_pembelian'];
        $jumlahbayar = $datareq['jumlah_bayar'];
        $sisa_hutang = $datareq['sisa_hutang'];
        $metode_bayar = $datareq['metode_bayar'];
        $rand = rand(1000,9999);

        $nota = ModelNotaPembelianBarang::find($idnota);

        $sisaafter = $sisa_hutang - $jumlahbayar;

        if ($sisaafter > 0) {
            $status = 'Hutang';
        }elseif ($sisaafter == 0) {
            $status = 'Selesai';
        }

        //update nota pembelian
        $nota->dibayar = $nota->dibayar + $jumlahbayar;
        $nota->sisa = $sisaafter;
        $nota->status_nota = $status;
        $nota->save();

        //tambah history pembayaran
        $inputhistoryTransaksi = New ModelHistoryPembelianBarang();
                        $inputhistoryTransaksi->fill([

                            'id_nota_pembelian'=>$idnota,
                            'id_payment'=>$metode_bayar,
                            'totalbayar'=>$nota->total,
                            'dibayar'=>$jumlahbayar,
                            'sisa'=>$sisaafter,
                        ])->save();
            //catatan jurnal
            $cekhutang = Model_chartAkun::where('nama','Hutang Usaha')->first();
                $idhutang = $cekhutang->id;
                $cekidCOA = ModelMetodeBayar::find($metode_bayar);
                $ceksaldo  = Model_chartAkun::where('id',$cekidCOA->idcoa)->first();
                $idkasbannk = $ceksaldo->id;
                ControllerJurnal::catatanjurnal($idhutang,$jumlahbayar,0,$idnota.$rand);
                ControllerJurnal::catatanjurnal($idkasbannk,0,$jumlahbayar,$idnota.$rand);
            
            //updates coa
            $uphutang = Model_chartAkun::find($idhutang);
            $upkasbank  = Model_chartAkun::find($idkasbannk);   
            $hutangsaldo = $uphutang->saldo - $jumlahbayar;
            $kasbanksaldo = $upkasbank->saldo + $jumlahbayar;
            $uphutang->saldo = $hutangsaldo;    
            $upkasbank->saldo = $kasbanksaldo;
            $uphutang->save();
            $upkasbank->save();
                        
        return redirect()->route('PembelianBarang')->with('msgdone','');
    }


}

