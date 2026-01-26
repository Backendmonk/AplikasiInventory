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
                <h3 style="margin:0;">DUTA UTAMA GRAFIKA</h3>
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

    /* ================= PAGE ================= */
    @page {
        size: A4 portrait;
        margin: 6mm;
    }

    /* ================= RESET TOTAL ================= */
    * {
        color: #000 !important;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }

    /* ================= BODY ================= */
    body {
        margin: 0 !important;
        padding: 0 !important;
        font-size: 11pt !important;
        line-height: 1.35 !important;
    }

    /* ================= MATIKAN GRID BOOTSTRAP ================= */
    .container,
    .container-fluid,
    .row,
    [class*="col-"] {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }

    /* ================= CARD JADI TEKS ================= */
    .card,
    .card-header,
    .card-body {
        margin: 0 !important;
        padding: 0 !important;
    }

    /* ================= TABLE ================= */
    table {
        width: 100% !important;
        border-collapse: collapse !important;
    }

    th,
    td {
        font-size: 11pt !important;
        line-height: 1.35 !important;

        padding-left: 8mm !important;
        padding-right: 5mm !important;
        padding-top: 1.2mm !important;
        padding-bottom: 1.2mm !important;

        vertical-align: top !important;
        text-align: left !important;
        border: none !important;
    }

    th {
        font-weight: bold !important;
    }

    /* ================= TOTAL JADI TEKS BIASA ================= */
    h4,
    .total-text {
        font-size: 11pt !important;
        font-weight: normal !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* ================= HILANGKAN DATA BARANG ================= */
    .print-area-inventory {
        display: none !important;
    }

    /* ================= MATIKAN WARNA ================= */
    .bg-light,
    .bg-primary,
    .bg-success,
    .text-primary,
    .text-success,
    .badge {
        background: transparent !important;
        color: #000 !important;
    }

    /* ================= HIDE UI ================= */
    .no-print,
    .btn,
    nav,
    aside,
    header,
    footer,
    .navbar,
    .sidebar,
    .breadcrumb {
        display: none !important;
    }

    /* ================= DATATABLE OFF ================= */
    .dataTables_length,
    .dataTables_filter,
    .dataTables_info,
    .dataTables_paginate,
    hr {
        display: none !important;
    }
}



</style>




@endsection