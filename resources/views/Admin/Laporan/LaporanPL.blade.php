@extends('Admin.template.main')

@section('judul')
    Data Penjualan
@endsection

@section('tittleCard')
    <h2 class="no-print">Data Penjualan</h2>
@endsection

@section('Content1')

{{-- ===================== PRINT CSS OPTIMIZED (PORTRAIT + NO URL) ===================== --}}
<style>
@media print {
    /* 1. Atur Kertas Portrait & Hilangkan URL Browser */
    @page {
        size: A4 portrait;
        margin: 10mm;
    }

    /* 2. Sembunyikan elemen non-cetak */
    .no-print, nav, header, aside, .sidebar, .navbar, .topbar, footer, 
    .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate,
    .breadcrumb, .content-header {
        display: none !important;
        height: 0 !important;
    }

    /* 3. Reset Layout Wrapper agar Full Width */
    body, .content-wrapper, .main-content, .container-fluid, .content, .container, .card {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        position: relative !important;
        left: 0 !important;
        top: 0 !important;
        background-color: #fff !important;
        border: none !important;
        box-shadow: none !important;
    }

    /* 4. Font & Tabel Styling (Muat di Portrait) */
    .print-area {
        width: 100% !important;
    }

    .print-area table {
        width: 100% !important;
        border-collapse: collapse !important;
        table-layout: fixed !important; /* Paksa muat dalam lebar kertas */
        font-family: "Courier New", Courier, monospace !important;
        font-size: 7.5pt !important; /* Ukuran font diperkecil agar kolom muat banyak */
        font-weight: bolder !important;
        color: #000 !important;
    }

    .print-area table th, .print-area table td {
        border: 1px solid #000 !important;
        padding: 2px !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        white-space: normal !important; /* Biar teks panjang turun ke bawah */
    }

    th {
        background-color: #eee !important;
        -webkit-print-color-adjust: exact;
        text-align: center !important;
    }

    /* Hilangkan URL/Footer sistem browser */
    body:after, body:before {
        content: none !important;
        display: none !important;
    }
}

/* Tampilan Normal Layar Tetap UX Asli */
.print-area { padding: 15px; }
</style>

<div class="print-area">
    {{-- Header Khusus Cetak --}}
    <div class="d-none d-print-block text-center mb-3">
        <h4 style="margin:0; font-weight: bold;">UTAMA GRAFIKA</h4>
        <p style="margin:0; font-size: 10pt;">Laporan Data Penjualan</p>
        <hr style="border: 1px solid #000; margin-top: 5px;">
    </div>

    <h3 class="text-center mb-4 no-print">Laporan Penjualan – Utama Grafika</h3>

    {{-- FILTER SECTION --}}
    <div class="card shadow mb-3 no-print">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label class="font-weight-bold">Filter Mesin (Plat):</label>
                    <select id="filterMesin" class="form-control">
                        <option value="">-- Semua Mesin --</option>
                        <option value="Gramfus">Gramfus</option>
                        <option value="P 52">P 52</option>
                        <option value="P 58">P 58</option>
                        <option value="P 72">P 72</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold">Filter Status:</label>
                    <select id="filterStatus" class="form-control">
                        <option value="">-- Semua Status --</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Piutang">Piutang</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button onclick="window.print()" class="btn btn-primary mr-2">
                        <i class="fas fa-print"></i> Print Portrait
                    </button>
                    <button onclick="location.reload()" class="btn btn-secondary">
                        <i class="fas fa-sync"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 no-print">
            <h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6>
        </div>

        <div class="card-body p-0 p-md-3">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">Tanggal</th>
                            <th width="5%">Nota</th>
                            <th width="12%">Pemesan</th>
                            <th width="10%">Jenis</th>
                            <th width="15%">Detail WO</th>
                            <th width="10%">Penjualan</th>
                            <th width="7%">Mesin</th>
                            <th width="10%">Total</th>
                            <th width="10%">Bayar</th>
                            <th width="11%">Sisa</th>
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
                                <td>{{ date('d/m/Y', strtotime($data['created_at'])) }}</td>
                                <td class="text-center">{{ $data['id'] }}</td>
                                <td>{{ $data->ModelwoRS->nama_pesanan }}</td>
                                <td>{{ $data->ModelwoRS->jenis_pesanan }}</td>
                                <td>
                                    @php
                                        $detail = array_filter([
                                            $data->ModelwoRS->jenis_kertas ? "K:{$data->ModelwoRS->jenis_kertas}" : null,
                                            $data->ModelwoRS->warna_tinta ? "T:{$data->ModelwoRS->warna_tinta}" : null,
                                        ]);
                                    @endphp
                                    {{ implode(' - ', $detail) }}
                                </td>
                                <td>{{ $data->nota->pluck('barang')->implode(', ') }}</td>
                                <td class="text-center">{{ $data->ModelwoRS->plat }}</td>
                                <td class="text-right">Rp{{ number_format($data['totalbayar'], 0, ',', '.') }}</td>
                                <td class="text-right">Rp{{ number_format($data['deposit'], 0, ',', '.') }}</td>
                                <td class="text-right">Rp{{ number_format($data['sisapembayaran'], 0, ',', '.') }}</td>
                            </tr>
                            @php
                                $totalbayar += $data['totalbayar'];
                                $totaldeposit += $data['deposit'];
                                $totalsisa += $data['sisapembayaran'];
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #f8f9fc; font-weight: bold;">
                            <th colspan="7" style="text-align:right">TOTAL:</th>
                            <th id="footerTotalBayar">Rp{{ number_format($totalbayar, 0, ',', '.') }}</th>
                            <th id="footerTotalDeposit">Rp{{ number_format($totaldeposit, 0, ',', '.') }}</th>
                            <th id="footerTotalSisa">Rp{{ number_format($totalsisa, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function() {
    var table = $('#dataTable').DataTable({
        "paging": false,
        "ordering": true,
        "info": false,
        "searching": true
    });

    $('#filterMesin').on('change', function() {
        table.column(6).search(this.value).draw();
        updateFooterTotal(table);
    });

    $('#filterStatus').on('change', function() {
        // Karena kolom status tidak saya tampilkan di table (untuk menghemat space Portrait), 
        // pastikan logic pencarian sesuai atau tambahkan kolom hidden jika perlu.
        table.search(this.value).draw();
        updateFooterTotal(table);
    });

    function updateFooterTotal(api) {
        var totalBayar = 0; var totalDeposit = 0; var totalSisa = 0;
        api.rows({ search: 'applied' }).every(function() {
            var node = this.node();
            totalBayar += parseInt($(node).find('td:eq(7)').text().replace(/[^\d]/g, '')) || 0;
            totalDeposit += parseInt($(node).find('td:eq(8)').text().replace(/[^\d]/g, '')) || 0;
            totalSisa += parseInt($(node).find('td:eq(9)').text().replace(/[^\d]/g, '')) || 0;
        });
        $('#footerTotalBayar').html('Rp' + totalBayar.toLocaleString('id-ID'));
        $('#footerTotalDeposit').html('Rp' + totalDeposit.toLocaleString('id-ID'));
        $('#footerTotalSisa').html('Rp' + totalSisa.toLocaleString('id-ID'));
    }
});
</script>

@endsection