<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelBarang;
use App\Models\ModelInvKeluar;
use App\Models\ModelRekanan;
use App\Models\ModelWO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ControllerWO extends Controller
{
    //


    public function Wodashboard(){

            $reqdatawo  = [
                
                'datawo'=>ModelWO::all()

            ];

        return view ('Admin.Workorder.Wodashboard',$reqdatawo);
    }   


    public function Addwo(){

        $data = [

                'getdataRekanan' => ModelRekanan::all(),
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
                'status'                  => $status

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

                'datawoperid' => ModelWO::where('id','=',$toolswo['idwo'])->first(),
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
            try {
               foreach ($items as $item) {
                 $inputketbInv = new ModelInvKeluar();
                # code...
                    $inputketbInv->fill([
                        'id_wo'=>$idwo,
                        'id_barang'=>$item['barang'],
                        'qty'=>$item['jumlah']
                    ]);

                    $inputketbInv->save();   
               }
               return redirect()->route('workorder')->with('msgdone',' ');
            } catch (\Throwable $th) {
                  return redirect()->route('workorder')->with('error',' ');
            }
        }
        //note yang harus ditambah
        /*


            1 .ubah logika untuk tombol selesai, dimana tombol inventory Keluar akan tidak bisa diakses lagi jika sudah ada barang keluar (sudah)
            2. tambahkan barang barang yang keluar di detail Wo (sudah)
            3. Kurangi barang yang keluar
            4. cek barang yang keluar apakah stoknya ada atau tidak jika tidak maka akan tidak bisa di proses (sudah)
            5. Selesai apa bila nota sudah dibuat !
            6. Harga Akan Keluar Jika Sudah Selesai Nota.. ! Hapus Harga di tambah Wo

        */



    ///////// NOTA ///////////




    public function Notadashboard(){
         $reqdatawont  = [
                
                'datawo'=>ModelWO::where('Status','=','Selesai')->get(),

            ];
        return view('Admin.WorkOrder.Nota',$reqdatawont);
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

                    'datawoget'=>ModelWO::where('id','=',$idwo)->first(),
                    'datawo'=>ModelWO::where('Status','=','Open')->get(),
                ];

        if ($cekinv > 0 ) {
            # code...   
             return view('Admin.WorkOrder.Notaitem',$dataWOfNota);
    }
        else{
             return redirect()->route('notaadd')->with('errorinv',' ');
        }

    }

       
}
