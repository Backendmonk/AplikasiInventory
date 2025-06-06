<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ControllerAuthUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

route::middleware(['guest'])->group(function(){
    Route::controller(ControllerAuthUser::class)->group(function(){
        route::get('/','DirrectLoginNonUser')->name('login');
        route::get('/tambahuser','UseraddBackend')->name('userReg');

        route::post('/registerUser','Registeruser');
        route::post('/logincek','proseslogin');
        route::get('/home','homelogout');
    });
    

});

route::middleware(['auth'])->group(function(){
    
    route::middleware('userauth:Admin')->group(function(){
        route::controller(AdminController::class)->group(function(){
            route::get('/Admin/Home','HomeAdmin');
        });
        
    });

});

