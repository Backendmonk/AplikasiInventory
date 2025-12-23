<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Model_chartAkun;
use App\Models\ModelAlurStok;
use App\Models\ModelBarang;
use App\Models\ModelHistoryPembayaran;
use App\Models\ModelInvKeluar;
use App\Models\MOdelMetodeBayar;
use App\Models\ModelNota;
use App\Models\ModelOperator;
use App\Models\ModelPembayaranNota;
use App\Models\ModelRekanan;
use App\Models\ModelStok;
use App\Models\ModelWO;
use Illuminate\Auth\Events\Logout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ControllerWO extends Controller
{
    //

    
    public function Wodashboard(){

            $reqdatawo  = [
                
                'datawo'=>ModelWO::all(),
                

            ];

        return view ('Admin.Workorder.Wodashboard',$reqdatawo);
    }   


    public function Addwo(){

        $data = [

                'getdataRekanan' => ModelRekanan::all(),
                'dataoperator'=>ModelOperator::all(),
        ] ;  

        return view ('Admin.Workorder.WoAdd',$data); 
    }

    public function ProsesAddWo( Request $reqDataWo){
        $status = "Open";
        
        $dataWO = [
                'diterimaTanggal'         => $reqDataWo->diterima_tgl,
                'selesaitanggal'          => $reqDataWo->selesai_tgl,
                'nama_pesanan'            => $reqDataWo->nama_pemesan,
                'jenis_pesanan'           => $reqDataWo->jenis_pesanan,
                'jumlah_pesanan'          => $reqDataWo->jumlah_pesanan,
                'jumlah_kertasdicetak'    => $reqDataWo->jumlah_kertasdicetak,
                'jenis_kertas'            => $reqDataWo->jenis_kertas,
                'warna_tinta'             => $reqDataWo->warna_tinta,
                'ukuran_cetak'            => $reqDataWo->ukuran_cetak,
                'ukuran_jadi'             => $reqDataWo->ukuran_jadi,
                'ukuran_rangkapsusun'     => $reqDataWo->rangka_susunan,
                'reproduksi'              => $reqDataWo->reproduksi,
                'sistemjilid'             => $reqDataWo->sistem_jilid,
                'statusorder'             => $reqDataWo->status_order,
                'plat'                    => $reqDataWo->plat,
                'nomoratorstart'          => $reqDataWo->nomorator_start,
                'warnatinta'              => $reqDataWo->warna_tinta2,
                'isiperbuku'              => $reqDataWo->isi_perbuku,
                'harga'                   => $reqDataWo->harga,
                'keterangan'              => $reqDataWo->keterangan,
                'status'                  => $status,
                'OperatorCetak'          => $reqDataWo->operatorCetak,
                'OperatorPotong'         => $reqDataWo->operatorPotong,
                'operatorProduksi'      => $reqDataWo->operatorProduksi,

        ];

        return $this-> AddtotbWO($dataWO);
    }


    private function AddtotbWO($dataWO){


        $prosesaddtowo = new ModelWO();

            $prosesaddtowo -> fill([
               'diterimaTanggal'       => $dataWO['diterimaTanggal'] ?? null,
                'selesaitanggal'        => $dataWO['selesaitanggal'] ?? null,
                'nama_pesanan'          => $dataWO['nama_pesanan'] ?? null,
                'jenis_pesanan'         => $dataWO['jenis_pesanan'] ?? null,
                'jumlah_pesanan'        => $dataWO['jumlah_pesanan'] ?? null,
                'jumlah_kertasdicetak'  => $dataWO['jumlah_kertasdicetak'] ?? null,
                'jenis_kertas'          => $dataWO['jenis_kertas'] ?? null,
                'warna_tinta'           => $dataWO['warna_tinta'] ?? null,
                'ukuran_cetak'          => $dataWO['ukuran_cetak'] ?? null,
                'ukuran_jadi'           => $dataWO['ukuran_jadi'] ?? null,
                'ukuran_rangkapsusun'   => $dataWO['ukuran_rangkapsusun'] ?? null,
                'reproduksi'            => $dataWO['reproduksi'] ?? null,
                'sistemjilid'           => $dataWO['sistemjilid'] ?? null,
                'statusorder'           => $dataWO['statusorder'] ?? null,
                'plat'                  => $dataWO['plat'] ?? null,
                'nomoratorstart'        => $dataWO['nomoratorstart'] ?? null,
                'warnatinta'            => $dataWO['warnatinta'] ?? null,
                'isiperbuku'            => $dataWO['isiperbuku'] ?? null,
                'harga'                 => $dataWO['harga'] ?? null,
                'status'                => $dataWO['status'] ?? null,
                'keterangan'            => $dataWO['keterangan'] ?? null,
                'id_operatorcetak'         => $dataWO['OperatorCetak'] ?? null,
                'id_operatorpotong'        => $dataWO['OperatorPotong'] ?? null,
                'id_operatorproduksi'     => $dataWO['operatorProduksi'] ?? null,
            ]);


            $prosesaddtowo->save();
            return redirect()->route('workorder')->with('msgdone','');
    }



    public function toolswo(Request $reqtoolswo){

        $toolswo = [

            'detail'=>$reqtoolswo->detail,
            'selesai'=>$reqtoolswo->selesaikan,
            'hapus'=>$reqtoolswo->hapus,
            'idwo' =>$reqtoolswo->idwo
        ];
        //cekketersediaan   
        $cekbarang = ModelInvKeluar::where('id_wo','=',$toolswo['idwo'])->count();

        if ($toolswo['detail'] != NULL) {
            $data  = [

                'datawoperid' => ModelWO::where('id','=',$toolswo['idwo'])->with('wocetak')->with('wopotong')->with('woproduksi')->first(),
                'datainvwo'=>ModelInvKeluar::where('id_wo','=',$toolswo['idwo'])->with('databarangwo')->get()
            ];
            return view('Admin.WorkOrder.wodetail',$data);
        }elseif ($toolswo['selesai']) {

            if ($cekbarang > 0) {
                 return redirect()->route('workorder')->with('SudahadanInv','');
            }else{

                  $getdata  = [ 

                    'databarang'=>ModelBarang::where('status','=','Aktif')->get(),
                    'datawo'=>ModelWO::where('id','=',$toolswo['idwo'])->first()
                  ];


                  return view('Admin.WorkOrder.InvKeluar',$getdata);
            }
                  
        }elseif ($toolswo['hapus'] !=NULL) {
            

            if ($cekbarang > 0) {
               return redirect()->route('workorder')->with('gagalhapus','');
            }else{

                ModelWO::where('id','=',$toolswo['idwo'])->delete();
                return redirect()->route('workorder')->with('msgdonehps','');

            }
        }


    }

        public function InvKeluar(request $reqdatainv){
            $datainv =[

                'item'=>$reqdatainv->items,
                'idwo'=>$reqdatainv->idwo,
                

            ];

            return $this->inputinvkeluar($datainv);
        }


        private function inputinvkeluar($datainv){

            $items = $datainv['item'];
            $idwo = $datainv['idwo'];
            $totalHargaBeli = 0 ;
            try {
               foreach ($items as $item) {
                 $inputketbInv = new ModelInvKeluar();
                # code...
                    $inputketbInv->fill([
                        'id_wo'=>$idwo,
                        'id_barang'=>$item['barang'],
                        'qty'=>$item['jumlah']
                    ]);


                    $update = ModelBarang::find($item['barang']);
                    $hppbarang = $update['HargaBeli'];
                    $totalHargaBeli += $hppbarang*$item['jumlah'];


                    $Stoksistem =  $update->stok_barang;
              
                        /*
                                cek apakah qty keluar apakah lebih besar dari stok yang ada di sistem ?
                        */
                    if ($item['jumlah'] > $Stoksistem) {
                         return redirect()->route('workorder')->with('Gagalinputbsr',' ');
                        break;
                    }else{
                         $stokupdate = $Stoksistem - $item['jumlah'];

                       
                        //jalankan stok update barang
                         $update->stok_barang = $stokupdate;

                        //input ke alur stok
                         $inputtotbalurStok = new ModelAlurStok();
                         $keterangan = "Stok Keluar di Work Order No-".$idwo;

                         $inputtotbalurStok->fill([
                                'idbarang'=>$item['barang'],
                                'Stok_Awal'=>$Stoksistem, 
                                'Stok_Akhir'=>$stokupdate,
                                'keterangan'=>$keterangan

                         ]);

                         $updatestoktbStok = ModelStok::where('idbarang','=',$item['barang'])->first();
                         $pertanggal = date('y-m-d');
                         $updatestoktbStok->fill([
                            'idbarang'=>$item['barang'],
                            'stok'=>$stokupdate,
                            'pertanggal'=>$pertanggal

                         ]);

            
                         $updatestoktbStok->save();
                         $update->save();
                         $inputtotbalurStok->save(); 
                           //input dan sesuaikan stok di db
                         $inputketbInv->save();
                    }
                        
                     
               }
               //akutansi HPP terhadap Persediaan (barang keluar)
            
               $idHPP = Model_chartAkun::where('nama','=','Harga Pokok Penjualan')->first();
               $idPersediaan = Model_chartAkun::where('nama','=','Persediaan Asset')->first();


                ControllerJurnal::catatanjurnal($idHPP['id'],$totalHargaBeli,0,$idwo);
                ControllerJurnal::catatanjurnal( $idPersediaan['id'],0,$totalHargaBeli,$idwo);
                //end Akutansi 

            //update coa 
                
               $updateHPP = Model_chartAkun::find($idHPP['id']);
               $updatePersediaan = Model_chartAkun::find($idPersediaan['id']);

               $hppsekarang = $updateHPP['saldo'] + $totalHargaBeli;
               $persediaansekarang = $updatePersediaan['saldo']+$totalHargaBeli;

               $updateHPP ->fill([

                'saldo'=>$hppsekarang
               ]);
               $updatePersediaan->fill([
                'saldo'=>$persediaansekarang
               ]);
               //end update COA

               

               
              return redirect()->route('workorder')->with('msgdone',' ');
            } catch (\Throwable $th) {
                  return redirect()->route('workorder')->with('error',' ');
            }
        }
        //note yang harus ditambah
        /*


            1 .ubah logika untuk tombol selesai, dimana tombol inventory Keluar akan tidak bisa diakses lagi jika sudah ada barang keluar (sudah)
            2. tambahkan barang barang yang keluar di detail Wo (sudah)
            3. Kurangi barang yang keluar dan jika barang di input lebih dari stok ada , akan ada warning (sudah)
            4. cek barang yang keluar apakah stoknya ada atau tidak jika tidak maka akan tidak bisa di proses (sudah)
            5. Selesai apa bila nota sudah dibuat !
            6. Harga Akan Keluar Jika Sudah Selesai Nota.. ! Hapus Harga di tambah Wo
            7. Validasi Hapus

        */



    ///////// NOTA ///////////




    public function Notadashboard(){
         $reqdatawont  = [
                
                'datawo'=>ModelWO::where('Status','=','Piutang')
                ->get(),

            ];
        return view('Admin.WorkOrder.Nota',$reqdatawont);
    }

    public function Notaselesai(Request $reqdatawont){

         $reqdatawont  = [
                
                'datawo'=>ModelWO::where('Status','=','Selesai')
                ->get(),

            ];
        return view('Admin.WorkOrder.NotaSelesai',$reqdatawont);
    }

    public function Addnotavw(){
         $reqdatawont  = [
                
                'datawo'=>ModelWO::where('Status','=','Open')->get(),

            ];
        return view('Admin.WorkOrder.NotaAdd',$reqdatawont);

    }



    public function NotaItems(request $reqdata){

        //cek ketersediaan inventory 

        $idwo = $reqdata->idwo;
        $cekinv = ModelInvKeluar::where('id_wo','=',$idwo)->count();

        $dataWOfNota = [

                    'datawo'=>ModelWO::where('id', $idwo)
                                ->where('Status', 'Open')
                                ->first(),
                    'databarangKeluar'=>ModelInvKeluar::where('id_wo','=',$idwo)->with('databarangwo')->get(),
                    'datametodebayar'=>MOdelMetodeBayar::all()
                ];

        if ($cekinv > 0 ) {
            # code...   
             return view('Admin.WorkOrder.Notaitem',$dataWOfNota);
    }
        else{
             return redirect()->route('notaadd')->with('errorinv',' ');
        }

    }



    //oreder selesai ketika sudah ada nota
    
    //harga keluar jika sudah ada nota
    // FUNCSI INI ADALAH FUNGSI YANGDIGUNAKAN UNTUK MELAKUKAN UPDATE TERHADAP WORK ORDER, DIMANA YANG DIUPDATE ADALAH STATUS DAN HARGA

    private function updateworkroderHrS($dataupwo){

        $idwo = $dataupwo['idwo'];
        $totalharga = $dataupwo['totalharga'];
        $status = $dataupwo['status'];
        $updatedatawosthr = ModelWO::find($idwo);

        $updatedatawosthr ->fill([

            'harga'=>$totalharga,
            'status'=>$status


        ]);

        $updatedatawosthr->save();
         return redirect()->route('nota')->with('msgdone','');

        

    }
///// input ke nota/////
    public function inputnota(Request $reqdatanota){

       $datanota = [

        'idwo'=>$reqdatanota->idwo,
        'items'=>$reqdatanota->items,
        'deposit'=>$reqdatanota->deposit,
        'totalharga'=>$reqdatanota->total,
        'metodebayar'=>$reqdatanota->metodebayar
       ];

       return $this->inputnotatodb($datanota);

    }


    private function inputnotatodb($datanota){

        $idwo = $datanota['idwo'];
        $metodepembayaran = $datanota['metodebayar'];
        $items = $datanota['items'];
        $tanggal = date('d');
        $bulan  =date('m');
        $dates = date('y-m-d');
        $nonota = $tanggal.$bulan.$idwo;
        $totalbayar = (int) $datanota['totalharga'];
        $deposit  = (int) preg_replace('/[^0-9]/', '',$datanota['deposit']);
        $sisa = $totalbayar - $deposit;

        $totalharga  = 0;
        foreach ($items as $databarang ) {
            $inputketbnota = new ModelNota();
            $inputketbnota->fill([

                'nonota'=>$nonota,
                'nomorwo'=>$idwo,
                'barang'=>$databarang['barang'],
                'qty'=>$databarang['jumlah'],
                'Harga'=>$databarang['harga'],
                'total'=>$databarang['harga']*$databarang['jumlah']


            ]);
              

            $totalharga+= $inputketbnota['total'];
        }


        /// Input Pembayaran NOta

        $inpembayaran = new ModelPembayaranNota();
        

        $inpembayaran->fill([
            'id'=>$nonota,
            'totalbayar'=>$totalharga,
            'deposit'=>$deposit,
            'sisapembayaran'=>$sisa,
            'idwo'=>$idwo
        ]);


        //

        $inputHistory  = new ModelHistoryPembayaran();

        $inputHistory ->fill([
            'idNota'=>$nonota,
            'totalbayar'=>$totalharga,
            'dibayarkan'=>$deposit,
            'sisa'=>$sisa,
            'pertanggal'=>$dates,
            'id_paymentmethod'=>$metodepembayaran
        ]);

        $inputHistory->Save();
        $inpembayaran->save();
        $inputketbnota->save();


        //update status dan total harga  di WORK ORDER jika sisa lebih dari 0 maka akan termasuk piutang
        //LOGIKA INI DIGUNAKAN UNTUK MEMUNCULKAN TOTAL HARGA PADA WO DAN STATUSNYA

        if ($sisa > 0) {
           $dataupwo =[

            'idwo'=>$idwo,
            'totalharga' => $totalharga,
            'status'=>'Piutang'
        ];

        // Jurnal Piutang
        $cekidpenjualan = Model_chartAkun::where('nama','=','Penjualan')->first();
        $cekidpiutang = Model_chartAkun::where('nama','=','Piutang Rekanan')->first();
        $cekidcoaMetodebayar  =MOdelMetodeBayar::where('id','=',$metodepembayaran)->first();
        $idakunpenjualan = $cekidpenjualan['id'];
        $idakunPembayaran = $cekidcoaMetodebayar['idcoa'];
        $idpiutang = $cekidpiutang['id'];
        //pakaid nota
        ControllerJurnal::catatanjurnal($idakunPembayaran,$deposit,0,$nonota);
        ControllerJurnal::catatanjurnal($idpiutang,$deposit,0,$nonota);
        ControllerJurnal::catatanjurnal( $idakunpenjualan,0,$totalharga,$nonota);

        //update coa besok copas dibawah

         $updatecoaAsset = Model_chartAkun::find($idakunPembayaran);
         $updatecoaPenjualan = Model_chartAkun::find($idakunpenjualan);
         $updatecoapiutang  = Model_chartAkun::find($idpiutang);

               //selesaikan Done (todo list buat update coa, tapi pertama harus car iidulu berapa isi saldo coanya)
            $saldoAsset = $updatecoaAsset['saldo'];
            $saldoPenjualan = $updatecoaPenjualan['saldo'];
            $saldoPiutang = $updatecoapiutang['saldo'];

            $totalpiutang = $totalharga-$deposit;
            $totalsaldoAsset = $saldoAsset+$deposit;
            $totalsaldopiutang = $totalpiutang;
            $totalsaldopenjualan  = $saldoPenjualan+$totalharga;
            

               $updatecoaAsset->fill([
                    'saldo'=>$totalsaldoAsset
               ]);

               $updatecoaPenjualan->fill([
                    'saldo'=>$totalsaldopenjualan
               ]);
               $updatecoapiutang->fill([

                    'saldo'=>$totalsaldopiutang
               ]);

               $updatecoaAsset->save();
               $updatecoaPenjualan->save();
               $updatecoapiutang->save();
        

        
         return $this->updateworkroderHrS($dataupwo);
        }else{
            $dataupwo =[

            'idwo'=>$idwo,
            'totalharga' => $totalharga,
            'status'=>'Selesai' 
        ];

          //jurnal selesai, ini untuk jurnal jika dibaayr cash dan tidak ada piutang usaha
        $cekidpenjualan = Model_chartAkun::where('nama','=','Penjualan')->first();
        $cekidcoaMetodebayar  =MOdelMetodeBayar::where('id','=',$metodepembayaran)->first();
        $idakunpenjualan = $cekidpenjualan['id'];
        $idakunPembayaran = $cekidcoaMetodebayar['idcoa'];

        ControllerJurnal::catatanjurnal($idakunPembayaran,$totalharga,0,$nonota);
        ControllerJurnal::catatanjurnal( $idakunpenjualan,0,$totalharga,$nonota);

        //update Saldo COA
            $updatecoaAsset = Model_chartAkun::find($idakunPembayaran);
            $updatecoaPenjualan = Model_chartAkun::find($idakunpenjualan);

               //selesaikan Done (todo list buat update coa, tapi pertama harus car iidulu berapa isi saldo coanya)
            $saldoAsset = $updatecoaAsset['saldo'];
            $saldoPenjualan = $updatecoaPenjualan['saldo'];

            $totalsaldoAsset = $saldoAsset+$totalharga;
            $totalsaldopenjualan  = $saldoPenjualan+$totalharga;

               $updatecoaAsset->fill([
                    'saldo'=>$totalsaldoAsset
               ]);

               $updatecoaPenjualan->fill([
                    'saldo'=>$totalsaldopenjualan
               ]);

               $updatecoaAsset->save();
               $updatecoaPenjualan->save();
         return $this->updateworkroderHrS($dataupwo);

        }

       
    }
    


     public function notatools(Request $reqdatanotas){

        $tools = [

            'detail'=>$reqdatanotas->detail,
            'pelunasan'=>$reqdatanotas->pelunasan,
            'history'=>$reqdatanotas->history
        ];
        $idwo = $reqdatanotas->idwo;
        $data = [


            'wo'=>ModelWO::where('id','=',$idwo)->first(),
            'nota'=>ModelNota::where('nomorwo','=',$idwo)->first(),
            'notadata'=>ModelNota::where('nomorwo','=',$idwo)->get(),
            'pembayaran'=>ModelPembayaranNota::where('idwo','=',$idwo)->first(),
            'datametodebayar'=>MOdelMetodeBayar::all()
        ];

        if ($tools['detail'] !=NULL) {
        return view('Admin.WorkOrder.DetailNota',$data);
        }elseif ($tools['pelunasan']!=NULL) {
           return view('Admin.WorkOrder.pelunasan',$data);
        }elseif($tools['history'] !=NUll){

        //ambil id wo terlebih dahulu untuk megecek karena pada tabel hostory pembayaran, karena pada fungsi ini idnota tidak terdefinisikan jadi akan diambil melalui modelpembayaran yang mengandung id nota sesuai dengan id wo terpilih
         $getidwo = ModelPembayaranNota::where('idwo','=',$idwo)->first();
         $idnota = $getidwo['id'];

         //setelah id nota didapatkan maka proses view bisa dilanjutkan

         $getdatahistory = [
            
         'history'=>ModelHistoryPembayaran::where('idNota','=',$idnota)->get()
        
        ];

         return view('Admin.WorkOrder.HistoryTransaksi',$getdatahistory);
        }
        
       
    }


    public function pelunasan( Request $reqdatapelunasan){

    $datapelunasan = [
       'idnota' => $reqdatapelunasan->idnota,
       'deposit' => $reqdatapelunasan->deposit,
       'sisabayar' => $reqdatapelunasan->sisabayar,
       'bayaransekarang' => $reqdatapelunasan->bayaransekarang,
       'totalharganota'=>$reqdatapelunasan->totalharganota,
       'metodebayar'=>$reqdatapelunasan->metodebayar

    ];

    return $this->ProsesPelunasan($datapelunasan);
       

    }

    private function ProsesPelunasan($datapelunasan){
        $updateedDeposit = $datapelunasan['deposit'] + $datapelunasan['bayaransekarang'];
        $updatesisapembayaran = $datapelunasan['sisabayar']-$datapelunasan['bayaransekarang'];
        $dates = date('y-m-d');

        $metodepembayaran = $datapelunasan['metodebayar'];

    
        $cekidpiutang = Model_chartAkun::where('nama','=','Piutang Rekanan')->first();
        $cekidcoaMetodebayar  =MOdelMetodeBayar::where('id','=',$metodepembayaran)->first();
        $idakunPembayaran = $cekidcoaMetodebayar['idcoa'];
        $idpiutang = $cekidpiutang['id'];
        //pakaid nota
        ControllerJurnal::catatanjurnal($idakunPembayaran,$datapelunasan['bayaransekarang'],0,$datapelunasan['idnota']);
        ControllerJurnal::catatanjurnal( $idpiutang,0,$datapelunasan['bayaransekarang'],$datapelunasan['idnota']);

          $updatecoaAsset = Model_chartAkun::find($idakunPembayaran);
          $updatecoapiutang  = Model_chartAkun::find($idpiutang);
            
          $saldoAsset = $updatecoaAsset['saldo'];
            
            $saldoPiutang = $updatecoapiutang['saldo'];

           $sisahutang = $saldoPiutang - $datapelunasan['deposit'];
           $totalsaldoAsset = $saldoAsset+$datapelunasan['deposit'];
          
            

               $updatecoaAsset->fill([
                    'saldo'=>$totalsaldoAsset
               ]);

              
               $updatecoapiutang->fill([

                    'saldo'=>$sisahutang
               ]);

               $updatecoaAsset->save();
               $updatecoapiutang->save();
      

  try {
              //update nota
             $updatedataNota  = ModelPembayaranNota::find($datapelunasan['idnota']);
             $updatedataNota->fill([
            'deposit'=>$updateedDeposit,
            'sisapembayaran'=>$updatesisapembayaran,
            
            
        ]);
        //input ke history bayar

        $inputtotbHistory  = new ModelHistoryPembayaran();

        $inputtotbHistory->fill([
            'idNota'=>$datapelunasan['idnota'],
            'totalbayar'=>$datapelunasan['totalharganota'],
            'dibayarkan'=>$datapelunasan['bayaransekarang'],
            'sisa'=>$updatesisapembayaran,
            'pertanggal'=>$dates

        ]);

        //get id wo from data pembayaran Nota UNTUK UPDATE STATUS DI WO, TIDAK PERLU UPDATE HARGA KARENA HARGA KAN SUDAH KETEMU

        $getidwo = ModelPembayaranNota::where('id','=',$datapelunasan['idnota'])->first();
        $idwo = $getidwo['idwo'];
        $updatedatawosthr = ModelWO::find($idwo);


        //cek apakah sisa masih lebih besar dari uang yang dibayarakan ?

        if ($datapelunasan['sisabayar'] > $datapelunasan['bayaransekarang']) {
            $updatedatawosthr ->fill([
            'status'=>'Piutang'
        ]);

        }else{
            $updatedatawosthr ->fill([
            'status'=>'Selesai'
        ]);

        }

        
        $updatedatawosthr->save();
         $updatedataNota->save();
        $inputtotbHistory->save();
         return redirect()->route('nota')->with('msgdone','');



  } catch (\Throwable $th) {
    //throw $th;
     return redirect()->route('nota')->with('msgerror','');

  }
            
       

        

    }
       
}
