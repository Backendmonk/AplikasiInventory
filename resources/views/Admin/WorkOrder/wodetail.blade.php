@extends('Admin.template.main')

@section('judul')
        Detail Work Order
@endsection

@section('Judulisi')
    <h2 class="no-print">Detail Work Order</h2>
@endsection

@section('Content1')

@if (session()->has('msgdone'))
<script>
Swal.fire({ title: "Berhasil", text: "Berhasil Tambah Barang", icon: "success" });
</script>
@endif

@if (session()->has('msgdoneEdt'))
<script>
Swal.fire({ title: "Berhasil", text: "Berhasil Edit Barang", icon: "success" });
</script>
@endif

@if (session()->has('msgdonehps'))
<script>
Swal.fire({ title: "Berhasil", text: "Berhasil Dihapus", icon: "success" });
</script>
@endif

@if (session()->has('gagal'))
<script>
Swal.fire({ title: "Gagal", text: "Kesalahan", icon: "error" });
</script>
@endif

@if(session('msgerror'))
<div class="alert alert-danger">{{ session('msgerror') }}</div>
@endif

<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-3" id="printArea">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center no-print">
            <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i> Detail Work Order</h5>
            <div>
                <button class="btn btn-light btn-sm me-2" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print
                </button>
                <span class="badge bg-success">{{ $datawoperid->status }}</span>
            </div>
        </div>

        <div class="card-body">
            {{-- HEADER CETAK (Hanya tampil saat print) --}}
            <div class="d-none d-print-block text-center mb-4">
                <h3 style="margin:0;">UTAMA GRAFIKA</h3>
                <h5 style="margin:0;">DETAIL WORK ORDER</h5>
                <hr style="border: 1px solid #000;">
            </div>

            {{-- DATA WORK ORDER --}}
            <div class="row mb-4">
                <div class="col-md-6 col-6">
                    <table class="table table-sm table-striped">
                        <tr><th>Diterima Tgl</th><td>{{ $datawoperid->diterimaTanggal }}</td></tr>
                        <tr><th>Selesai Tgl</th><td>{{ $datawoperid->selesaiTanggal }}</td></tr>
                        <tr><th>Nama Pemesan</th><td>{{ $datawoperid->nama_pesanan }}</td></tr>
                        <tr><th>Jenis Pesanan</th><td>{{ $datawoperid->jenis_pesanan }}</td></tr>
                        <tr><th>Jumlah Pesanan</th><td>{{ $datawoperid->jumlah_pesanan }}</td></tr>
                        <tr><th>Jml Kertas Dicetak</th><td>{{ $datawoperid->jumlah_kertasdicetak }}</td></tr>
                        <tr><th>Jenis Kertas</th><td>{{ $datawoperid->jenis_kertas }}</td></tr>
                        <tr><th>Warna Tinta</th><td>{{ $datawoperid->warna_tinta }}</td></tr>
                        <tr><th>Nomorator Start</th><td>{{ $datawoperid->nomoratorstart }}</td></tr>
                    </table>
                </div>

                <div class="col-md-6 col-6">
                    <table class="table table-sm table-striped">
                        <tr><th>Ukuran Cetak</th><td>{{ $datawoperid->ukuran_cetak }}</td></tr>
                        <tr><th>Ukuran Jadi</th><td>{{ $datawoperid->ukuran_jadi }}</td></tr>
                        <tr><th>Rangka/Susunan</th><td>{{ $datawoperid->ukuran_rangkapsusun }}</td></tr>
                        <tr><th>Reproduksi</th><td>{{ $datawoperid->reproduksi }}</td></tr>
                        <tr><th>Sistem Jilid</th><td>{{ $datawoperid->sistemjilid }}</td></tr>
                        <tr><th>Status Order</th><td>{{ $datawoperid->statusorder }}</td></tr>
                        <tr><th>Plat</th><td>{{ $datawoperid->plat }}</td></tr>
                        <tr><th>Operator Cetak</th><td>{{ $datawoperid->wocetak->nama_operator ?? 'N/A' }}</td></tr>
                        <tr><th>Operator Potong</th><td>{{ $datawoperid->wopotong->nama_operator ?? 'N/A' }}</td></tr>
                        <tr><th>Operator Produksi</th><td>{{ $datawoperid->woproduksi->nama_operator ?? 'N/A' }}</td></tr>
                    </table>
                </div>
            </div>

            {{-- HARGA --}}
            <div class="mb-4">
                <h6 class="text-primary no-print"><i class="bi bi-cash-coin me-2"></i> Harga</h6>
                <div class="p-3 bg-light border rounded text-end">
                    <h4 class="mb-0 text-success">
                        <strong class="total-text">Total: Rp {{ number_format($datawoperid->harga, 0, ',', '.') }}</strong>
                    </h4>
                </div>
            </div>

            {{-- KETERANGAN --}}
            <h6 class="text-primary"><i class="bi bi-list-check me-2"></i> Rincian Tambahan</h6>
            <div class="border rounded bg-light p-3">
                <pre class="mb-0">{{ $datawoperid->keterangan }}</pre>
            </div>

        </div>
    </div>
</div>

<br>

<div class="card shadow mb-4 print-area-inventory">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Qty Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datainvwo as $data)
                    <tr>
                        <td>{{ $data->databarangwo->nama_barang }}</td>
                        <td>{{ $data->qty }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ===================== CSS PRINT PORTRAIT OPTIMIZED ===================== --}}
<style>
@media print {
    /* 1. Atur Portrait & Hilangkan URL Web melalui Margin */
    @page {
        size: A4 portrait;
        margin: 10mm 15mm; 
    }

    /* 2. Paksa Sembunyikan Sidebar & Elemen Template Admin */
    /* Menargetkan selector umum AdminLTE / Template Laravel Admin */
    .main-sidebar, .sidebar, .main-header, .navbar, .main-footer, footer, 
    .no-print, aside, header, nav, .topbar, .btn, .breadcrumb {
        display: none !important;
    }

    /* 3. Reset Container agar tidak ada margin kiri (bekas sidebar) */
    body, .content-wrapper, .main-content, .container-fluid, .content, .container {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        position: relative !important;
        left: 0 !important;
        background-color: #fff !important;
    }

    /* 4. Font Styling (Khas Dot Matrix / Courier) */
    * {
        color: #000 !important;
        box-shadow: none !important;
    }

    body {
        font-family: "Courier New", Courier, monospace !important;
        font-size: 11px !important;
    }

    /* 5. Tabel Formatting */
    table {
        width: 100% !important;
        border-collapse: collapse !important;
        table-layout: fixed !important;
    }

    table th, table td {
        border: 1px solid #000 !important;
        padding: 4px 6px !important;
        word-wrap: break-word !important;
    }

    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
        margin-bottom: 5px !important;
    }

    .bg-light { background: transparent !important; }
    .text-success { color: #000 !important; }

    /* 6. Hilangkan elemen DataTable */
    .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
        display: none !important;
    }

    /* Footer Cetak */
    body:after {
        content: "Dicetak pada {{ date('d-m-Y H:i') }}";
        display: block;
        text-align: center;
        margin-top: 15px;
        font-size: 9px;
    }
}
</style>

@endsection