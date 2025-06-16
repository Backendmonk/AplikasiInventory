<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function HomeAdmin(){

        return response()
        ->view('Admin.DashboardAdmin')
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
    }


    public function ProfileAdmin(){

        return view('Admin.ProfileAdmin');
    }


     public function logout(){

         Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('login');
    }
}


