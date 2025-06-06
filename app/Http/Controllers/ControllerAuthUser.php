<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerAuthUser extends Controller
{
    

    public function DirrectLoginNonUser(){
         if (Auth::check()) {
        if (Auth::user()->jenis_akun == 'Admin') {
            return redirect('Admin/Home');
        } elseif (Auth::user()->jenis_akun == 'Kasir') {
            return redirect('Kasir/Home');
        }
    }

    return response()
        ->view('welcome')
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
       
    }

    public function UseraddBackend(){

        return view('registerAdmin');
    }

    public function logout(){

         Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('login');
    }




    ///Proses login
    //public proses login untuk mengambil data dari user
       public function proseslogin(Request $reqcredential){
           

                $usercredential =[

                'username'=>$reqcredential->username,
                'password'=>$reqcredential->password
            ];
       
           


            ///pass ke fungsi login dengan membawa isi usercredential
        return $this->login($usercredential);
    }

    //fugnsi private login akan mengambil data dari proses login dan di eksekusi secara private untuk logika dengan mangambil isi berupa usercredentiala

        
        private function login( $usercredential){

            if (  empty($usercredential['username']) ||
                  empty($usercredential['password'])){
                return redirect()->route('login')->with('nullfield','');
            }
            else{
                if (Auth::attempt($usercredential)) {
                    if (Auth::user()->jenis_akun =='Admin') {
                         return redirect('Admin/Home');
                    }elseif (Auth::user()->jenis_akun =='Kasir') {
                        return redirect('Kasir/Home');
                    }else{
                        Auth::logout();
                        return redirect()->route('login');
                    }
                }else{

                    return redirect()->route('login')->with('nullakun','');
                    
                }
           
        }
    }

 



    ///proses daftar user

    public function Registeruser(request $reqdatainput)
    {

        $nama = $reqdatainput->nama;
        $username = $reqdatainput->username;
        $password = bcrypt($reqdatainput->password);
        $JA = $reqdatainput->jenisAkun;

        $cekketersediaaan  = User::where('username','=',$username)->count();

        //cek apakah akun tersedia atau tidak ?
    
        if ($cekketersediaaan > 0) {
            return redirect()->route('userReg')->with('MsgAkunada','');
        }else{
            try {
            $inputtoTableUser = new User;
            
            $inputtoTableUser->fill([
            'name'=>$nama,
            'username' =>$username,
            'password' => $password,
            'jenis_akun' => $JA
            ]);

            $inputtoTableUser->save();
            return redirect()->route('login')->with('MsgDone','');
            



        } catch (\Throwable $th) {
            return redirect()->route('login')->with('errormsg','');
        }

        }

        
    }
}
