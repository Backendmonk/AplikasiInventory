<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ControllerAuthUser;
use App\Http\Controllers\ControllerBarangAdmin;
use App\Http\Controllers\ControllerPreorder;
use App\Http\Controllers\ControllerRekanan;
use App\Http\Controllers\ControllerStokAdmin;
use App\Http\Controllers\COntrollerStokKasir;
use App\Http\Controllers\ControllerWO;
use App\Http\Controllers\ControllerWOKasir;
use App\Http\Controllers\KasirController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web Routes for your application. These
| Routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guest'])->group(function(){
    Route::controller(ControllerAuthUser::class)->group(function(){
        Route::get('/','DirrectLoginNonUser')->name('login');
        Route::get('/tambahuser','UseraddBackend')->name('userReg');

        Route::post('/registerUser','Registeruser');
        Route::post('/logincek','proseslogin');
        Route::get('/logout','logout');
    });




});

Route::middleware(['auth'])->group(function(){
    
    Route::middleware('userauth:Admin')->group(function(){
        Route::controller(AdminController::class)->group(function(){
            Route::get('/Admin/Home','HomeAdmin')->name('DashboardAdmin');
            route::get('/Admin/profile','ProfileAdmin')->name('AdminProfil');

            //admin Profile 
            route::post('/Admin/UpdateDataAdmin','UpDataAdmin');
            ///
            Route::get('/logout','logout');


         

        });

         Route::controller(ControllerBarangAdmin::class)->group(function(){
            //Barang
            route::get('/Admin/Barang/DataBarang','DataBarang')->name('Barang');
            route::post('/Admin/Barang/TambahBarang','TambahBarang');
            route::post('/Admin/Barang/AddBarang','Addbarang');
            route::post('/Admin/Barang/ToolsEditBarang','ToolsEditBarang');
            route::post('/Admin/Barang/EditBarang','EditBarang');
            route::get('/Admin/Barang/BarangOff','BarangOff');


            //Kategori
            route::get('/Admin/Barang/Kategori','KategoriBarangView')->name('Kategori');
            route::post('/Admin/Barang/TambahKategori','TambahKategoriBarang');
            route::post('/Admin/Barang/AddKatagori','KatagoriBarangAdd');
            route::POST('/Admin/Barang/ToolsEdit','ToolsKategori');
            route::post ('/Admin/Barang/EditKatagori','EditKategori');
         });


         route::controller(ControllerStokAdmin::class)->group(function(){
            route::get('/Admin/JumlahStokBarang','JumlahStokBarangView');
            route::get('/Admin/StokControll','StokControllview')->name('stokcontrol');
            route::post('/Admin/Stok/ToolsalurStok','ToolsAlurStok');
            route::post('/Admin/Stok/Opname','OpnameStok');
            
         });

         route::controller(ControllerRekanan::class)->group(function(){

            route::get('/Admin/Rekanan','RekananView')->name('rekanan');
            route::post('/Admin/Rekanan/Tambahrekanan','TambahRekananView'); 
            route::post('/Admin/Rekanan/Addrekanan','Addrekanan');
            route::post('/Admin/Barang/ToolsRekanan','ToolsRekanan');
            route::post('/Admin/Rekanan/Editrekanan','Editrekanan');
            // route::get('/Admin/Rekanan/PO','PO');

            
         });


        //  route::controller(ControllerPreorder::class)->group(function(){
        //     route::get('/Admin/PreOrder/AddPreOrder','TambahPreorder');
        //     route::get('/Admin/PO/DataPO','DataPO')->name('PurOrder');

        //     route::post('/Admin/PO/TambahPO','ProsesPO');
        //     route::post('/Admin/PO/ToolsPO','detailPO');
        //  });



        route::controller(ControllerWO::class)->group(function(){

            route::get('/Admin/Sales/WorkOrder','Wodashboard')->name('workorder');
            route::post('/Admin/wo/Addwo','Addwo');
            route::post('/Admin/Wo/ProsesAddwo','ProsesAddWo');
            route::post('/Admin/wo/Toolswo','toolswo');
            route::get('/Admin/Sales/Nota','Notadashboard')->name('nota');
            route::get('/Admin/sales/Addnota','Addnotavw')->name('notaadd');
            route::post('/Admin/Sales/NotaItems','NotaItems');
            route::post('/Admin/Sales/InputNota','inputnota');
            route::post('/Admin/WO/InvKeluar','InvKeluar');

            route::post('/Admin/Sales/notaview','notaview');
            
        });


         
    });




  
    Route::middleware('userauth:Kasir')->group(function(){
        Route::controller(KasirController::class)->group(function(){
                Route::get('/Kasir/Home','HomeKasir')->name('DashboardKasir');
                Route::get('/logout','logout');

        });



        route::controller(COntrollerStokKasir::class)->group(function(){
            route::get('/Kasir/JumlahStokBarang','JumlahStokBarangView');
            route::get('/Kasir/StokControll','StokControllview')->name('stokcontrolKasir');
            route::post('/Kasir/Stok/ToolsalurStok','ToolsAlurStok');
            route::post('/Kasir/Stok/Opname','OpnameStok');
            
         });


         
        route::controller(ControllerWOKasir::class)->group(function(){

            route::get('/Kasir/Sales/WorkOrder','Wodashboard')->name('workorderKasir');
            route::post('/Kasir/wo/Addwo','Addwo');
            route::post('/Kasir/Wo/ProsesAddwo','ProsesAddWo');
            route::post('/Kasir/wo/Toolswo','toolswo');
            route::get('/Kasir/Sales/Nota','Notadashboard')->name('notaKasir');
            route::get('/Kasir/sales/Addnota','Addnotavw')->name('notaaddKasir');
            route::post('/Kasir/Sales/NotaItems','NotaItems');
            route::post('/Kasir/Sales/InputNota','inputnota');
            route::post('/Kasir/WO/InvKeluar','InvKeluar');

            route::post('/Kasir/Sales/notaview','notaview');
            
        });


    });


});





