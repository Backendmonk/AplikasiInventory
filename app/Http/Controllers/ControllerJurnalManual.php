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
    $request->validate([
        'tanggal' => 'required|date',
        'nomor_nota' => 'required|string',
        'akun_id' => 'required|array',
        'akun_id.*' => 'required',
        'debit' => 'required|array',
        'kredit' => 'required|array',
        'keterangan_umum' => 'nullable|string',
    ]);

    try {
        $akun_ids = $request->akun_id;
        $debits   = $request->debit;
        $kredits  = $request->kredit;
        $id_nota  = $request->nomor_nota;

        foreach ($akun_ids as $index => $id_akun) {

            $nominal_debit  = (float) ($debits[$index] ?? 0);
            $nominal_kredit = (float) ($kredits[$index] ?? 0);

            // skip kalau kosong
            if ($nominal_debit == 0 && $nominal_kredit == 0) {
                continue;
            }

            // SIMPAN JURNAL
            \App\Http\Controllers\ControllerJurnal::catatanjurnal(
                $id_akun,
                $nominal_debit,
                $nominal_kredit,
                $id_nota
            );

            // ================================
            // UPDATE SALDO COA (SESUAI LOGIKA MU)
            // ================================
            $coa = Model_chartAkun::find($id_akun);

            if ($coa) {
                $saldoAwal = $coa->saldo;

                // debit nambah, kredit ngurang
                $saldoAkhir = $saldoAwal + $nominal_debit - $nominal_kredit;

                $coa->fill([
                    'saldo' => $saldoAkhir
                ]);

                $coa->save();
            }
        }

        return redirect()->back()->with('msgdone', 'Jurnal & saldo COA berhasil disimpan');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menyimpan jurnal: ' . $e->getMessage());
    }
}
}