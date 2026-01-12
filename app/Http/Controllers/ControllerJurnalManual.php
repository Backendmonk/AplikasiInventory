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
        'debit' => 'required|array',
        'kredit' => 'required|array',
    ]);
        // Ambil tanggal dari input untuk back date
        $dates = \Carbon\Carbon::parse($request->tanggal)->toDateTimeString();
        $id_nota = $request->nomor_nota;

        foreach ($request->akun_id as $index => $id_akun) {
            $nominal_debit  = (float) ($request->debit[$index] ?? 0);
            $nominal_kredit = (float) ($request->kredit[$index] ?? 0);

            if ($nominal_debit == 0 && $nominal_kredit == 0) continue;

            // SEDERHANA: Langsung panggil dengan variabel $dates
            ControllerJurnal::catatanjurnal($id_akun, $nominal_debit, $nominal_kredit, $id_nota, $dates, $dates);

            // Update Saldo COA
            $coa = Model_chartAkun::find($id_akun);
            if ($coa) {
                $coa->saldo = $coa->saldo + $nominal_debit - $nominal_kredit;
                $coa->save();
            }
        }

        return redirect()->back()->with('msgdone', 'Data berhasil disimpan');
    
}
}