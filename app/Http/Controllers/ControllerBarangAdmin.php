<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

            return view('Admin.Barang.DataBarang');
         }

}
