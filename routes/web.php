<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ControllerAuthUser;
use App\Http\Controllers\ControllerBarangAdmin;
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


            ///barang
         

        });

         Route::controller(ControllerBarangAdmin::class)->group(function(){
            //Barang
            route::get('/Admin/Barang/DataBarang','DataBarang')->name('Barang');


            //Kategori
            route::get('/Admin/Barang/Kategori','KategoriBarangView')->name('Kategori');
            route::post('/Admin/Barang/TambahKategori','TambahKategoriBarang');
            route::post('/Admin/Barang/AddKatagori','KatagoriBarangAdd');
            route::POST('/Admin/Barang/ToolsEdit','ToolsKategori');
            route::post ('/Admin/Barang/EditKatagori','EditKategori');
         });
    });

});

