<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartOfAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
           $now = Carbon::now();

       DB::table('tb_tipeakun')->insert([
    ['category' => 'Asset', 'code' => 1052, 'nama_code' => 'Kas dan Bank', 'normal_balance' => 'Debit'],
    ['category' => 'Asset', 'code' => 1204, 'nama_code' => 'Piutang Usaha', 'normal_balance' => 'Debit'],
    ['category' => 'Asset', 'code' => 1302, 'nama_code' => 'Persediaan', 'normal_balance' => 'Debit'],
    ['category' => 'Asset', 'code' => 1431, 'nama_code' => 'Aset Lancar Lainnya', 'normal_balance' => 'Debit'],
    ['category' => 'Asset', 'code' => 1502, 'nama_code' => 'Aset Tetap', 'normal_balance' => 'Debit'],
    ['category' => 'Asset', 'code' => 1602, 'nama_code' => 'Akumulasi Penyusutan', 'normal_balance' => 'Credit'],
    ['category' => 'Asset', 'code' => 1701, 'nama_code' => 'Aset Lainnya', 'normal_balance' => 'Debit'],

    ['category' => 'Liability', 'code' => 2004, 'nama_code' => 'Hutang Usaha', 'normal_balance' => 'Credit'],
    ['category' => 'Liability', 'code' => 2101, 'nama_code' => 'Kartu Kredit', 'normal_balance' => 'Credit'],
    ['category' => 'Liability', 'code' => 2291, 'nama_code' => 'Kewajiban Lancar Lainnya', 'normal_balance' => 'Credit'],
    ['category' => 'Liability', 'code' => 2301, 'nama_code' => 'Kewajiban Jangka Panjang', 'normal_balance' => 'Credit'],

    ['category' => 'Equity', 'code' => 3091, 'nama_code' => 'Modal Pemilik', 'normal_balance' => 'Credit'],
    ['category' => 'Equity', 'code' => 3092, 'nama_code' => 'Laba Ditahan', 'normal_balance' => 'Credit'],
    ['category' => 'Equity', 'code' => 3093, 'nama_code' => 'Prive Pemilik', 'normal_balance' => 'Debit'],

    ['category' => 'Income', 'code' => 4007, 'nama_code' => 'Pendapatan Usaha', 'normal_balance' => 'Credit'],
    ['category' => 'Income', 'code' => 4008, 'nama_code' => 'Pendapatan Lainnya', 'normal_balance' => 'Credit'],

    ['category' => 'Expense', 'code' => 5006, 'nama_code' => 'Harga Pokok Penjualan', 'normal_balance' => 'Debit'],
    ['category' => 'Expense', 'code' => 6902, 'nama_code' => 'Beban Operasional', 'normal_balance' => 'Debit'],
    ['category' => 'Expense', 'code' => 6903, 'nama_code' => 'Beban Lainnya', 'normal_balance' => 'Debit'],
    ['category' => 'Expense', 'code' => 6904, 'nama_code' => 'Beban Penyusutan & Amortisasi', 'normal_balance' => 'Debit'],
    ['category' => 'Expense', 'code' => 6905, 'nama_code' => 'Kerugian Aset', 'normal_balance' => 'Debit'],
]);
    }
}
