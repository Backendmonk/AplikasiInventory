@extends('Admin.template.main')

@section('judul')
    Detail Pembelian
@endsection

@section('Judulisi')
    <h2 class="no-print">Detail Nota Pembelian</h2>
@endsection

@section('Content1')

{{-- ===================== CSS PRINT OPTIMIZATION ===================== --}}
<style>
@media print {
    /* 1. Atur Kertas Portrait & Hilangkan URL/Header Browser */
    @page {
        size: A4 portrait;
        margin: 10mm;
    }

    /* 2. Sembunyikan Sidebar, Navbar, dan Elemen Admin Template */
    /* Tambahkan selektor sesuai class template Anda (umumnya .main-sidebar, .main-header, dll) */
    .main-sidebar, .sidebar, .main-header, .navbar, .main-footer, footer, 
    .no-print, aside, header, .btn, .breadcrumb, .content-header {
        display: none !important;
    }
     /* Hilangkan sidebar, navbar, dan footer template secara total */
    .main-sidebar, .sidebar, .main-header, .navbar, .main-footer, footer, 
    .no-print, aside, header, .btn, .breadcrumb, .content-header, .footer-timestamp {
        display: none !important;
    }

    /* 3. Reset Wrapper Template agar ke pojok kiri atas & Full Width */
    body, .content-wrapper, .main-content, .container-fluid, .content, .container {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        position: relative !important;
        left: 0 !important;
        top: 0 !important;
        background-color: #fff !important;
    }

    /* 4. Penyesuaian Konten Nota */
    .print-area {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Font Monospace agar tajam di printer */
    .print-area, .print-area table {
        font-family: "Courier New", Courier, monospace !important;
        font-size: 10pt !important;
        color: #000 !important;
    }

    /* Paksa Tabel agar muat dalam Portrait */
    .print-area table {
        width: 100% !important;
        border-collapse: collapse !important;
        table-layout: fixed !important; /* Mencegah kolom meluber keluar kertas */
    }

    .print-area table th, .print-area table td {
        border: 1px solid #000 !important;
        padding: 5px !important;
        word-wrap: break-word !important; /* Teks panjang akan turun ke bawah, bukan geser tabel */
    }

    /* Hilangkan Bayangan (Shadow) Card agar bersih */
    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
        margin-bottom: 10px !important;
    }

    .card-body {
        padding: 10px !important;
    }

    /* Pastikan angka rata kanan */
    .text-right, .text-end {
        text-align: right !important;
    }
}
</style>

<div class="print-area">
    {{-- Header Khusus Cetak (Hanya tampil saat print) --}}
    <div class="d-none d-print-block text-center mb-4">
        <h3 style="margin:0;">UTAMA GRAFIKA</h3>
        <p style="margin:0;">Detail Nota Pembelian Barang</p>
        <hr style="border: 1px solid #000;">
    </div>

    <h3 class="text-center mb-4 no-print">Detail Nota Pembelian – Utama Grafika</h3>

    {{-- ===================== FILTER & ACTION SECTION ===================== --}}
    <div class="card shadow mb-3 no-print">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <button onclick="window.print()" class="btn btn-primary mr-2">
                        <i class="fas fa-print"></i> Print Portrait
                    </button>
                    <button onclick="location.reload()" class="btn btn-secondary">
                        <i class="fas fa-sync"></i> Refresh Data
                    </button>
                </div>
                <div class="col-md-6 text-right">
                    @if(count($pembelianbarang) > 0)
                        <span class="badge badge-info p-2">Nota ID: #{{ $pembelianbarang[0]->notaPembelian->id }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- HEADER INFO NOTA --}}
    @if(count($pembelianbarang) > 0)
        @php $nota = $pembelianbarang[0]->notaPembelian; @endphp
        <div class="card mb-3 border-bottom">
            <div class="card-body">
                <div class="row">
                     <div class="col-3">
                        <strong>Tanggal:</strong><br>
                        {{ $nota->created_at->format('d-m-Y H:i') }}
                    </div>
                    <div class="col-3">
                        <strong>ID Nota:</strong><br>
                        #{{ $nota->id }}
                    </div>
                    <div class="col-3">
                        <strong>Total:</strong><br>
                        Rp {{ number_format($nota->total,0,',','.') }}
                    </div>
                    <div class="col-3">
                        <strong>Status:</strong><br>
                        <span class="badge {{ $nota->status_nota == 'Selesai' ? 'bg-success' : 'bg-warning' }} border">
                            {{ $nota->status_nota }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- TABLE DETAIL BARANG --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 no-print">
            <h6 class="m-0 font-weight-bold text-primary">Rincian Barang Pembelian</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="bg-light">
                            <th width="40px">No</th>
                            <th>Nama Barang</th>
                            <th width="80px">Qty</th>
                            <th width="120px">Harga</th>
                            <th width="140px">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @forelse($pembelianbarang as $i => $item)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $item->barangBeli->nama_barang ?? '-' }}</td>
                                <td class="text-center">{{ $item->jumlah_beli }}</td>
                                <td class="text-right">Rp {{ number_format($item->harga_beli,0,',','.') }}</td>
                                <td class="text-right">Rp {{ number_format($item->subtotal_harga_beli,0,',','.') }}</td>
                            </tr>
                            @php $grandTotal += $item->subtotal_harga_beli; @endphp
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data pembelian</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" style="text-align:right">TOTAL PEMBELIAN:</th>
                            <th class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            {{-- AREA TANDA TANGAN (Hanya muncul saat cetak) --}}
            <div class="d-none d-print-block mt-4">
                <table width="100%" style="border: none !important;">
                    <tr style="border: none !important;">
                        <td style="border: none !important; text-align: center; width: 40%;">
                            Penerima Barang,<br><br><br><br>
                            ( ..................... )
                        </td>
                        <td style="border: none !important; width: 20%;"></td>
                        <td style="border: none !important; text-align: center; width: 40%;">
                            Hormat Kami,<br><br><br><br>
                            ( ..................... )
                        </td>
                    </tr>
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
    if (!$.fn.DataTable.isDataTable('#dataTable')) {
        $('#dataTable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "searching": false
        });
    }
});
</script>

@endsection