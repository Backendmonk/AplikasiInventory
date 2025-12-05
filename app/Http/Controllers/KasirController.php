<?php

namespace App\Http\Controllers;

use App\Models\ModelPembayaranNota;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    //

     public function HomeKasir(Request $request){

       
       // default: tanggal awal dan akhir bulan ini
        $start = $request->input('start') 
            ? Carbon::parse($request->input('start'))->startOfDay()
            : Carbon::now()->startOfMonth()->startOfDay();

        $end = $request->input('end')
            ? Carbon::parse($request->input('end'))->endOfDay()
            : Carbon::now()->endOfMonth()->endOfDay();

        // Ambil data grouped by tanggal (YYYY-MM-DD)
        $data = ModelPembayaranNota::whereBetween('created_at', [$start, $end])
            ->selectRaw("DATE(created_at) as date, SUM(deposit) as total_deposit, SUM(totalbayar) as totalbayar")
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Buat rentang tanggal lengkap untuk memastikan hari tanpa transaksi muncul 0
        $period = [];
        $periodStart = $start->copy();
        while ($periodStart->lte($end)) {
            $period[] = $periodStart->format('Y-m-d');
            $periodStart->addDay();
        }

        // Map hasil query ke array keyed by date
        $map = $data->keyBy('date')->map(function($r){ return (float)$r->total_deposit; });

        // Siapkan arrays untuk chart & tabel
        $labels = [];
        $values = [];
        $rows = [];
        foreach ($period as $d) {
            $labels[] = $d;
            $val = isset($map[$d]) ? $map[$d] : 0;
            $values[] = $val;
            $rows[] = ['date' => $d, 'total_deposit' => $val];
        }

        // total keseluruhan di range
        $totalRange = array_sum($values);

        return view('Kasir.DashboardKasir', compact('labels','values','rows','start','end','totalRange'));
    
    }


     public function logoutkasir(){

         Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('login');
    }
}
