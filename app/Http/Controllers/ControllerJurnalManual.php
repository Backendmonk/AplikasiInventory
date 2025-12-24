<?php

namespace App\Http\Controllers;

use App\Models\Model_chartAkun;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;

class ControllerJurnalManual extends Controller
{
    //

    public function JurnalManual(){
        $data = [
            'COA'=>Model_chartAkun::all()
        ];
        return view('Admin.JurnalManual.Home', $data);

        
    }

public function SimpanJurnalManual(Request $request)
{
    // 1. Validasi Input
    $request->validate([
        'tanggal' => 'required|date',
        'nomor_nota' => 'required|string',
        'akun_id' => 'required|array',
        'akun_id.*' => 'required', // Memastikan setiap baris ada akun yang dipilih
        'debit' => 'required|array',
        'kredit' => 'required|array',
        'keterangan_umum' => 'nullable|string',
    ]);

    try {
        // Ambil data dari request
        $akun_ids = $request->akun_id;
        $debits   = $request->debit;
        $kredits  = $request->kredit;
        $id_nota  = $request->nomor_nota;

        // 2. Lakukan looping untuk menyimpan setiap baris jurnal
        foreach ($akun_ids as $index => $id_akun) {
            
            $nominal_debit  = $debits[$index] ?? 0;
            $nominal_kredit = $kredits[$index] ?? 0;

            // Lewati baris jika debit dan kredit sama-sama nol atau kosong
            if ($nominal_debit == 0 && $nominal_kredit == 0) {
                continue;
            }

            /** * 3. Memanggil fungsi static dari ControllerJurnal sesuai gambar Anda:
             * Parameter: ($id_akun, $debit, $kredit, $idnota)
             */
            \App\Http\Controllers\ControllerJurnal::catatanjurnal(
                $id_akun, 
                $nominal_debit, 
                $nominal_kredit, 
                $id_nota
            );
        }

        return redirect()->back()->with('msgdone', '');

    } catch (\Exception $e) {
        // Jika terjadi error, kembalikan pesan error
        return redirect()->back()->with('error', 'Gagal menyimpan jurnal: ' . $e->getMessage());
    }
}
}