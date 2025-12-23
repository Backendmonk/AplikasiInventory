<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Model_chartAkun;
use App\Models\MOdelJurnal;
use App\Models\ModelNota;
use App\Models\ModelPembayaranNota;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerLaporan extends Controller
{
    //

    public function LaporanHome(){

        return View('Admin.Laporan.Home');
    }


    public function Jurnalselected(){

        $tipeselected = ['selected'=>'Jurnal'];

        return view('Admin.Laporan.Rentangtanggal',$tipeselected);
    }

     public function Labarugiselected(){

        $tipeselected = ['selected'=>'Laba-Rugi'];

        return view('Admin.Laporan.Rentangtanggal',$tipeselected);
    }

     public function Neracaselected(){

        $tipeselected = ['selected'=>'Neraca'];

        return view('Admin.Laporan.Rentangtanggal',$tipeselected);
    }
    public function LaporanPenjualan(){

        $tipeselected = ['selected'=>'LaporanPenjualan'];

        return view('Admin.Laporan.Rentangtanggal',$tipeselected);
    }


    Public function ProsesLaporan(request $reqdatalaporan){



       $jenislaporan  = $reqdatalaporan-> jenis;


       //mengambil tanggal 
         $tanggalAwal  = Carbon::parse(trim($reqdatalaporan->tglawal))->startOfDay();
        $tanggalAkhir = Carbon::parse(trim($reqdatalaporan->tglakhir))->endOfDay();

       $tanggal  = [  'tanggalAwal'  => $tanggalAwal,
                        'tanggalAkhir' => $tanggalAkhir];
        
                    //logika tanggal 
        
                    if ($tanggal['tanggalAwal'] > $tanggal['tanggalAkhir']) {
                        # code...
                        return redirect()->route('Laporan')->with('MsgTglError','');
                    }else{
                        //redirect ke fungsi masing masing sesuai jenis laporan
                        if ($jenislaporan =='Jurnal') {
                            # code...
                                return $this->PanggilJurnal($tanggal);
                        }elseif ($jenislaporan=='Laba-Rugi') {
                            # code...
                                return $this->PanggilLabaRugi($tanggal);
                        }elseif ($jenislaporan=='Neraca') {
                            # code...
                             return $this->PanggilNeraca($tanggal);
                        }elseif($jenislaporan=='LaporanPenjualan'){
                            return $this->PanggilLapJul($tanggal);
                        }
                    }

    }

    //fungsi memanggil Jurnal
  private function PanggilJurnal($tanggal) {
    $tanggalAwal = $tanggal['tanggalAwal'];
    $tanggalAkhir = $tanggal['tanggalAkhir'];

    $data = [
        // Mengelompokkan berdasarkan idnota agar baris debet & kredit menyatu
        'Jurnal' => MOdelJurnal::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->with('idakun')
            ->orderBy('created_at', 'asc')
            ->orderBy('idnota', 'asc')
            ->get()
            ->groupBy('idnota'), // KUNCI PERUBAHAN DISINI
        'tanggalAwal' => $tanggalAwal,
        'tanggalAkhir' => $tanggalAkhir
    ];

    return view('Admin.Laporan.Jurnal', $data);
}


       Private Function PanggilLabaRugi($tanggal){

    $tanggalAwal = $tanggal['tanggalAwal'];
    $tanggalAkhir = $tanggal['tanggalAkhir'];

    // Ambil semua akun
    $akun = Model_chartAkun::all(); 
    $tanggal = [
        'tanggalAwal' => $tanggalAwal,
        'tanggalAkhir' => $tanggalAkhir
    ];

    foreach ($akun as $a) {
        $idAkun = $a->id;

        // Hitung total debit dan kredit dari jurnal pada periode yang diminta
        $jurnal = MOdelJurnal::where('id_akun', $idAkun)
                     ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                     ->get();

        $totalDebit = $jurnal->sum('debit');
        $totalKredit = $jurnal->sum('kredit');


        // Tentukan Saldo Akhir berdasarkan saldo normal (menggunakan kolom 'keterangan')
        $keteranganAkun = strtolower($a->keterangan);
        
        // Akun Nominal (Laba Rugi)
        if ($keteranganAkun == 'income') {
            // Saldo normal KREDIT (Pendapatan): Saldo = Kredit - Debit
            $a->saldo = $totalKredit - $totalDebit;
        } elseif ($keteranganAkun == 'expense') { 
            // Saldo normal DEBIT (Beban): Saldo = Debit - Kredit
            // Saldo beban di Laporan Laba Rugi biasanya ditampilkan sebagai nilai positif, 
            // dan dikurangi dari Pendapatan.
            $a->saldo = $totalDebit - $totalKredit;
        } else {
            // Akun Riil (Asset, Liability, Equity) diabaikan/diset 0 di Laba Rugi
            $a->saldo = 0; 
        }
    }

    // Mengirim semua akun (yang sudah dihitung saldonya) ke view
    return view('Admin.Laporan.labarugi', compact('akun', 'tanggal'));
}
    

      Private Function PanggilNeraca($tanggal){
    $tanggalAwal = $tanggal['tanggalAwal'];
    $tanggalAkhir = $tanggal['tanggalAkhir'];

    // 1. Ambil semua akun
    $akun = Model_chartAkun::all();
      $tanggal = [
        'tanggalAwal' => $tanggalAwal,
        'tanggalAkhir' => $tanggalAkhir
    ];

    foreach ($akun as $a) {
        // Ambil ID Akun untuk query Jurnal
        $idAkun = $a->id;

        // 2. Hitung total debit dan kredit dari jurnal pada periode yang diminta
        $jurnal = MOdelJurnal::where('id_akun', $idAkun)
                     ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                     ->get();

        $totalDebit = $jurnal->sum('debit');
        $totalKredit = $jurnal->sum('kredit');

        // 3. Tentukan Saldo Akhir berdasarkan saldo normal (menggunakan kolom 'keterangan')
        $keteranganAkun = strtolower($a->keterangan);

        // Akun Riil (Neraca)
        if ($keteranganAkun == 'asset') {
            // Saldo normal DEBIT: Saldo = Debit - Kredit
            $a->saldo = $totalDebit - $totalKredit;
        } elseif ($keteranganAkun == 'liability' || $keteranganAkun == 'equity') { 
            // Saldo normal KREDIT: Saldo = Kredit - Debit
            $a->saldo = $totalKredit - $totalDebit;
        } 
        
        // Akun Nominal (Income/Expense) - Dihitung untuk Laba Rugi, bukan Neraca.
        // Untuk Neraca, akun nominal harus menghasilkan saldo 0, kecuali untuk menghitung
        // penambahan/pengurangan di Ekuitas (Laba Rugi).
        // Karena Neraca yang Anda buat masih sederhana, kita akan set saldo 0 untuk akun Nominal
        // agar tidak muncul di kolom Debet/Kredit Neraca
        else {
            $a->saldo = 0; 
        }
        
        // CATATAN PENTING: Jika ada saldo awal, harus ditambahkan di sini.
        // Jika kolom 'saldo_awal' dihitung sebelum periode, maka:
        // $a->saldo = $a->saldo_awal + ($totalDebit - $totalKredit) * (1 jika saldo normal debit, -1 jika kredit)
        // Jika saldo_awal Anda diasumsikan 0.0 seperti di gambar, maka abaikan.
    }

    return view('Admin.Laporan.neraca', compact('akun', 'tanggal'));
}


    private function PanggilLapJul($tanggal){

     $tanggalAwal = $tanggal['tanggalAwal'];
    $tanggalAkhir = $tanggal['tanggalAkhir'];

        $notabr = [
            'nota' => ModelPembayaranNota::with(['ModelwoRS', 'nota'])
                ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                ->get()
        ];
            # code...
            
         
    return view('Admin.Laporan.LaporanPL',$notabr);

    
    }
}