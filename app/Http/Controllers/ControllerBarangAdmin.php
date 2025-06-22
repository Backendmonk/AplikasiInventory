<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelKategoriBarang;
use Illuminate\Http\Request;

class ControllerBarangAdmin extends Controller
{
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

          

            }

         }
}
