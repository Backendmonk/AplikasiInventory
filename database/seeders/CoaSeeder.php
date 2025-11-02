<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $now = Carbon::now();
        $today = $now->toDateString();

        $accounts = [
            // id | code | nama_code | category | normal_balance
            [20, '1022', 'Kas dan Bank', 'Debit'],
            [21, '1504', 'Piutang Usaha', 'Debit'],
            [22, '1372', 'Persediaan', 'Debit'],
            [23, '1461', 'Aset Lancar Lainnya', 'Debit'],
            [24, '1552', 'Aset Tetap', 'Debit'],
            [25, '1622', 'Penyusutan & Amortisasi', 'Debit'],
            [26, '1751', 'Aset Lainnya', 'Debit'],
            [27, '1401', 'Kerugian Aset', 'Debit'],
            [28, '2204', 'Hutang Usaha', 'Kredit'],
            [29, '2141', 'Kartu Kredit', 'Kredit'],
            [30, '2221', 'Kewajiban Lancar Lainnya', 'Kredit'],
            [31, '2331', 'Kewajiban Jangka Panjang', 'Kredit'],
            [32, '3092', 'Modal', 'Kredit'],
            [33, '4444', 'Pendapatan', 'Kredit'],
            [34, '7113', 'Pendapatan Lainnya', 'Kredit'],
            [35, '5022', 'Harga Pokok Penjualan', 'Debit'],
            [36, '6943', 'Beban Operasional', 'Debit'],
            [37, '6942', 'Beban Aset', 'Debit'],
            [38, '8921', 'Beban Lainnya', 'Debit'],
        ];

        // Memasukkan data ke database
        foreach ($accounts as $account) {
            DB::table('tb_chart_akun')->insert([ // Pastikan nama tabel ini benar
                'id_tipeakun' => $account[0],
                'kode' => $account[1],
                'nama' => $account[2],
                'keterangan' => $account[3], // Menggunakan saldo normal sebagai keterangan
                'saldo_awal' => 0,
                'tanggal_saldo_awal' => $today,
                'saldo' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
    
}
