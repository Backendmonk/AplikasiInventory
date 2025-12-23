<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ControllerAdminPembelianBarang;
use App\Http\Controllers\ControllerAuthUser;
use App\Http\Controllers\ControllerBarangAdmin;
use App\Http\Controllers\ControllerChartofAccount;
use App\Http\Controllers\ControllerJurnal;
use App\Http\Controllers\ControllerJurnalManual;
use App\Http\Controllers\ControllerLaporan;
use App\Http\Controllers\ControllerOperator;
use App\Http\Controllers\ControllerPayment;
use App\Http\Controllers\ControllerPembelian;
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
        // Route::get('/logout','logout');
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
            route::get('/Admin/Barang/ToolsEditBarang','ToolsEditBarang');
            route::post('/Admin/Barang/EditBarang','EditBarang');
            route::get('/Admin/Barang/BarangOff','BarangOff');


            //Kategori
            route::get('/Admin/Barang/Kategori','KategoriBarangView')->name('Kategori');
            route::post('/Admin/Barang/TambahKategori','TambahKategoriBarang');
            route::post('/Admin/Barang/AddKatagori','KatagoriBarangAdd');
            route::GET('/Admin/Barang/ToolsEdit','ToolsKategori');
            route::post ('/Admin/Barang/EditKatagori','EditKategori');

            route::post('/Admin/Barang/CekStokBarang','Stokrendah');
         });


         route::controller(ControllerStokAdmin::class)->group(function(){
            route::get('/Admin/JumlahStokBarang','JumlahStokBarangView');
            route::get('/Admin/StokControll','StokControllview')->name('stokcontrol');
            route::get('/Admin/Stok/ToolsalurStok','ToolsAlurStok');
            route::post('/Admin/Stok/Opname','OpnameStok');
            
         });

         route::controller(ControllerRekanan::class)->group(function(){

            route::get('/Admin/Rekanan','RekananView')->name('rekanan');
            route::post('/Admin/Rekanan/Tambahrekanan','TambahRekananView'); 
            route::post('/Admin/Rekanan/Addrekanan','Addrekanan');
            route::GET('/Admin/Barang/ToolsRekanan','ToolsRekanan');
            route::post('/Admin/Rekanan/Editrekanan','Editrekanan');
            

            
         });



        route::controller(ControllerWO::class)->group(function(){

            route::get('/Admin/Sales/WorkOrder','Wodashboard')->name('workorder');
            route::post('/Admin/wo/Addwo','Addwo');
            route::post('/Admin/Wo/ProsesAddwo','ProsesAddWo');
            route::get('/Admin/wo/Toolswo','toolswo');
            route::get('/Admin/Sales/Nota','Notadashboard')->name('nota');
            route::get('/Admin/sales/Addnota','Addnotavw')->name('notaadd');
            route::post('/Admin/Sales/NotaItems','NotaItems');
            route::post('/Admin/Sales/InputNota','inputnota');
            route::post('/Admin/WO/InvKeluar','InvKeluar');
            route::get('/Admin/Sales/notaview','notatools');
            route::post('/Admin/Sales/Pelunasan','pelunasan');
            route::get('/Admin/sales/notaselesai','Notaselesai');
      
            
        });


        route::controller(ControllerAdminPembelianBarang::class)->group(function(){

                route::get('/Admin/Pembelian','PembelianView')->name('Pembelian');
        });
        route::controller(ControllerChartofAccount::class)->group(function(){

                route::get('/Admin/ChartOfAccount','Coadashboard')->name('COAHome');
                route::post('/Admin/coa/TambahCOA','COAaddView');
                route::post('/Admin/COA/CoaAdd','CoaAdd');
        });


        route::controller(ControllerLaporan::class)->group(function(){

            route::get('/Admin/laporan','LaporanHome')->name('Laporan');
            route::get('Admin/laporan/jurnal','Jurnalselected');
            route::get('Admin/laporan/labarugi','Labarugiselected');
            route::get('Admin/laporan/neraca','Neracaselected');
            route::get('Admin/laporan/proses','ProsesLaporan');
            route::get('/Admin/Sales/Sales','LaporanPenjualan');

        });


        route::controller(ControllerPayment::class)->group(function(){
            route::get('/Admin/metodepembayaran','Homepayment')->name('payment');
            route::post('/Admin/Payment/TambahPayment','Paymentaddform');
            route::post('/Admin/Payment/PaymentAdd','Paymentadd');
        });

        route::controller(ControllerOperator::class)->group(function(){
            route::get('/Admin/Operator','OperatorHome')->name('OperatorHome');
            route::post('/Admin/Operator/TambahOperator','Operatoraddform');
            route::post('/Admin/Operator/OperatorAdd','Operatoradd');
            route::post('/Admin/Operator/ToolsEditOperator','ToolsOperator');
            
            
        });

        route::controller(ControllerPembelian::class)->group(function(){
            route::Get('/Admin/Pembelian','PembelianView')->name('PembelianBarang');
            route::Get('/Admin/Pembelian/TambahPembelian','pembeliantambah');

            route::post('/Admin/Pembelian/Process','ProsesPembelian');
            route::get('/Admin/Pembelian/Detail','DetailPembelian');
            route::post('/Admin/Pembelian/PelunasanHutang','PelunasanHutang');
        });

       route::controller(ControllerJurnalManual::class)->group(function(){
            route::Get('/Admin/JurnalManual','JurnalManual');
       });
    });








    /*


            end of admin Route, Route dibawah adalah route yang digunakan untuk route kasir

            route kasir dimulai dari auth 
    */
  
    Route::middleware('userauth:Kasir')->group(function(){
        Route::controller(KasirController::class)->group(function(){
                Route::get('/Kasir/Home','HomeKasir')->name('DashboardKasir');
                Route::get('/logoutksr','logoutkasir');

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

            route::post('/Kasir/Sales/notaview','notatools');
              route::post('/Kasir/Sales/Pelunasan','pelunasan');
                route::get('/Kasir/sales/notaselesai','Notaselesai');
            
        });


    });


});





