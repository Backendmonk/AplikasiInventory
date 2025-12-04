@extends('Admin.template.main')

@section('judul')
       Data Penjualan
@endsection

@section('tittleCard')
    <h2>Data Penjualan</h2>
@endsection

@section('Content1')

{{-- ===================== PRINT CSS ===================== --}}
<style>
@media print {

    /* sembunyikan elemen yang tidak boleh ikut tercetak */
    .no-print,
    nav,
    header,
    aside,
    .sidebar,
    .navbar,
    .topbar,
    footer {
        display: none !important;
    }

    /* khusus area yang ingin dicetak */
    .print-area {
        width: 100% !important;
        margin: 0;
        padding: 0;
    }
}
</style>

{{-- ===================== PRINT AREA WRAPPER START ===================== --}}
<div class="print-area">

    <h3 class="text-center mb-4 no-print">Laporan Penjualan – Utama Grafika</h3>

    <!-- Tombol print -->
    <button onclick="window.print()" class="btn btn-primary mb-3 no-print">
        Print Laporan
    </button>

    {{-- ===================== TABEL ASLI (TIDAK DIUBAH) ===================== --}}

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nomor Nota</th>
                            <th>Nama Pemesan</th>
                            <th>Jenis Pesanan</th>
                            <th>Total Bayar</th>
                            <th>Dibayarkan</th>
                            <th>Sisa</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $totalbayar = 0;
                            $totaldeposit = 0;
                            $totalsisa = 0;
                        @endphp

                        @foreach ($nota as $data)
                            <tr>
                                <td>{{ $data['created_at'] }}</td>
                                <td>{{ $data['id'] }}</td>
                                <td>{{ $data->ModelwoRS->nama_pesanan }}</td>
                                <td>{{ $data->ModelwoRS->jenis_pesanan }}</td>
                                <td>Rp.{{ number_format($data['totalbayar'], 0, ',', '.') }}</td>
                                <td>Rp.{{ number_format($data['deposit'], 0, ',', '.') }}</td>
                                <td>Rp.{{ number_format($data['sisapembayaran'], 0, ',', '.') }}</td>
                                <td>{{ $data->ModelwoRS->status }}</td>
                            </tr>

                            @php
                                $totalbayar += $data['totalbayar'];
                                $totaldeposit += $data['deposit'];
                                $totalsisa += $data['sisapembayaran'];
                            @endphp
                        @endforeach
                    </tbody>

                    <tfoot>
                        <th colspan="4"></th>
                        <th>Total Pembayaran : Rp.{{ number_format($totalbayar, 0, ',', '.') }}</th>
                        <th>Total Dibayarkan : Rp.{{ number_format($totaldeposit, 0, ',', '.') }}</th>
                        <th>Total Sisa : Rp.{{ number_format($totalsisa, 0, ',', '.') }}</th>
                        <th></th>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>

</div>
{{-- ===================== PRINT AREA END ===================== --}}

@endsection
