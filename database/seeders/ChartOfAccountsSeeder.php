<?php

namespace Database\Seeders;

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
           $tipeakun = [
            // ASET
            ['code' => '1052', 'nama_code' => 'Kas dan Bank', 'category' => 'Asset', 'normal_balance' => 'Debit'],
            ['code' => '1204', 'nama_code' => 'Piutang Usaha', 'category' => 'Asset', 'normal_balance' => 'Debit'],
            ['code' => '1302', 'nama_code' => 'Persediaan', 'category' => 'Asset', 'normal_balance' => 'Debit'],
            ['code' => '1431', 'nama_code' => 'Aset Lancar Lainnya', 'category' => 'Asset', 'normal_balance' => 'Debit'],
            ['code' => '1502', 'nama_code' => 'Aset Tetap', 'category' => 'Asset', 'normal_balance' => 'Debit'],
            ['code' => '1602', 'nama_code' => 'Penyusutan & Amortisasi', 'category' => 'Asset', 'normal_balance' => 'Debit'],
            ['code' => '1701', 'nama_code' => 'Aset Lainnya', 'category' => 'Asset', 'normal_balance' => 'Debit'],
            ['code' => '1801', 'nama_code' => 'Kerugian Aset', 'category' => 'Asset', 'normal_balance' => 'Debit'],

            // KEWAJIBAN
            ['code' => '2004', 'nama_code' => 'Hutang Usaha', 'category' => 'Liability', 'normal_balance' => 'Credit'],
            ['code' => '2101', 'nama_code' => 'Kartu Kredit', 'category' => 'Liability', 'normal_balance' => 'Credit'],
            ['code' => '2291', 'nama_code' => 'Kewajiban Lancar Lainnya', 'category' => 'Liability', 'normal_balance' => 'Credit'],
            ['code' => '2301', 'nama_code' => 'Kewajiban Jangka Panjang', 'category' => 'Liability', 'normal_balance' => 'Credit'],

            // MODAL
            ['code' => '3091', 'nama_code' => 'Modal', 'category' => 'Equity', 'normal_balance' => 'Credit'],

            // PENDAPATAN
            ['code' => '4007', 'nama_code' => 'Pendapatan', 'category' => 'Income', 'normal_balance' => 'Credit'],
            ['code' => '7902', 'nama_code' => 'Pendapatan Lainnya', 'category' => 'Income', 'normal_balance' => 'Credit'],

            // BEBAN
            ['code' => '5006', 'nama_code' => 'Harga Pokok Penjualan', 'category' => 'Expense', 'normal_balance' => 'Debit'],
            ['code' => '6902', 'nama_code' => 'Beban Operasional', 'category' => 'Expense', 'normal_balance' => 'Debit'],
            ['code' => '6904', 'nama_code' => 'Beban Aset', 'category' => 'Expense', 'normal_balance' => 'Debit'],
            ['code' => '8903', 'nama_code' => 'Beban Lainnya', 'category' => 'Expense', 'normal_balance' => 'Debit'],
        ];

        DB::table('tb_tipeakun')->insert($tipeakun);
    }
}
