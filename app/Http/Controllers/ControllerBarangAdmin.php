<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelBarang;
use App\Models\ModelKategoriBarang;
use Illuminate\Http\Request;

class ControllerBarangAdmin extends Controller
{
   //////////////////////////////// FUNGSI FUNGSI KATEGORI BARANG ADA DISINI////////////////////////////////////////////////////////

         public function KategoriBarangView(request $request){
            //memberikan limit untuk di load 
        

               // Ambil data paginasi manual
               $data =[

                  'Datakategori'=>ModelKategoriBarang::all()
                  
               ];


            return view('Admin.Barang.kategori',$data);
         }


         public function TambahKategoriBarang(){

            return view('Admin.Barang.TambahKategoriBarang');
         }

         public function KatagoriBarangAdd(request $reqkategori){

               $databarang = [
                  'id' => $reqkategori -> id,
                  'kategori'=>$reqkategori->kategori
               ];

               return $this->InputtoDbKategori($databarang);

         }


         private function InputtoDbKategori($databarang){

            try {
               //code...

               $inputtoTbKategori = new ModelKategoriBarang();

               $inputtoTbKategori->fill([
                  'id'=>$databarang['id'],
                  'Kategori'=>$databarang['kategori']
               ]);

               $inputtoTbKategori->save();
               return redirect()->route('Kategori')->with('msgdone','');

            } catch (\Throwable $th) {
               //throw $th;
           
                 return redirect()->route('Kategori')->with('gagal','');

          

            }

         }


         public function ToolsKategori(Request $reqdataTools ){

            $id  = $reqdataTools->idKategori;


            $tools = ['edit','hapus'];

            $TlsEdit = $reqdataTools->edit;
            $TlsHapus = $reqdataTools->hapus;

            if ($TlsEdit == $tools[0]) {
                $selectKategori = [
               
               'datakategori'=>ModelKategoriBarang::where('id','=',$id)->first()
               ];

               return view('Admin.Barang.EditKategori',$selectKategori);
            }elseif ($TlsHapus == $tools[1]) {
               
               ModelKategoriBarang::where('id','=',$id)->delete();

               return redirect()->route('Kategori')->with('msgdonehps','');
            }

           
         }



         ///edit kategori 

         public function EditKategori(request $reqdataedit){

            $dataedit = [

               'id'=>$reqdataedit->id,
               'kategori'=>$reqdataedit->kategori
            ];


            return $this->prosesEditKategori($dataedit);
         }


         private function prosesEditKategori($dataedit){

            $Update = ModelKategoriBarang::find($dataedit['id']);


            try {
               //code...

               $Update->Kategori = $dataedit['kategori'];

                $Update->save();

                return redirect()->route('Kategori')->with('msgdoneEdt','');

            } catch (\Throwable $th) {
               //throw $th;

               return redirect()->route('Kategori')->with('gagal','');


            }

            

         }


//////////////////////////////// FUNGSI FUNGSI BARANG ADA DISINI////////////////////////////////////////////////////////
         Public function DataBarang(){

            $Arrdatabarang = [
               'databarang'=>ModelBarang::with('Kategoribr')->where('Status','=','Aktif')->get()
            ];

            return view('Admin.Barang.DataBarang',$Arrdatabarang);
         }


         public function TambahBarang(){

            $ArrGetKategori = [
               'datakategori'=>ModelKategoriBarang::all()
            ];

            return view('Admin.Barang.TambahBarang',$ArrGetKategori);
         }


         public function Addbarang(Request $reqdatabarang){

            $databarang=[
               'id'=>$reqdatabarang->id,
               'namabarang'=>$reqdatabarang->namabarang,
               'kategori'=>$reqdatabarang->kategori,
               'qty'=>$reqdatabarang->qty

            ];


            return $this->prosesTambahBarang($databarang);
         }

         private function prosesTambahBarang($databarang){

            $InputToDb = new ModelBarang();
            $status = 'Aktif';
            $InputToDb -> fill([
               
               'id'=>$databarang['id'],
               'nama_barang'=>$databarang['namabarang'],
               'id_kategori'=>$databarang['kategori'],
               'stok_barang'=>$databarang['qty'],
               'Status'=>$status

               
            ]);

            try {
               $InputToDb->save();

               return redirect()->route('Barang')->with('msgdone','');
            } catch (\Throwable $th) {
               //throw $th;
               return redirect()->route('Barang')->with('gagal','');
            }
         }



         public function ToolsEditBarang(request $reqTools){

            $tools = [
               'edit'=>$reqTools->edit,
               'hapus'=>$reqTools->hapus,
               'sembunyi'=>$reqTools->sembunyi,
               'id'=>$reqTools->idbarang


            ];

             $id = $tools['id'];

            if ($tools['edit'] != Null) {
              
               //edit di sini
               return $this->EditbarangView($id);
            }elseif ($tools['hapus'] != NUll) {
               # code...//LOGIKA DITAMBHKAN KETIKA SUDAH MENGERJAKAN TRANSAKSI
               ModelBarang::where('id','=',$id)->delete();
               return redirect()->route('Barang')->with('msgdonehps','');
             
            }elseif ($tools['sembunyi'] !=Null) {
               # code...
               //sembunyikan Baragn
              
               $statusHidden = 'Sembunyi';
               $updatestatus = ModelBarang::find($id);
               $updatestatus -> Status = $statusHidden;

               $updatestatus->save();
                return redirect()->route('Barang')->with('msgdoneEdt','');

               
            }


         }


         public function EditbarangView($id){
            $databarang =[
               'barang'=>ModelBarang::with('Kategoribr')->where('id','=',$id)->first(),
               'datakategori'=>ModelKategoriBarang::all()
            ];
            return view('Admin.Barang.Editbarang',$databarang);
         }

}
