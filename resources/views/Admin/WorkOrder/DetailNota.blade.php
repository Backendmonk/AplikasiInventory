@extends('Admin.template.main')

@section('judul')
    Nota Bpk/Ibu
@endsection

@section('Content1')
<div class="print-area-wrapper">

    {{-- TOMBOL PRINT --}}
    <div class="d-flex justify-content-end mb-3 no-print">
        <button class="btn btn-success btn-sm" onclick="window.print()">
            <i class="bi bi-printer"></i> Print Nota
        </button>
    </div>

    {{-- AREA NOTA --}}
    <div class="nota-box">
        <div class="nota-inner">

            {{-- HEADER --}}
            <div class="nota-header">
                <h3>DUTA UTAMA GRAFIKA</h3>
                <p>Jl TK Irawadi 66 Panjer, Denpasar</p>
                <p>Telp: 0361 244061 / 8083976 / 8955186</p>
            </div>

            {{-- INFO NOTA --}}
            <table class="nota-info" width="100%">
                <tr>
                    <td width="55%">No Nota : <strong>{{ $nota->nomorwo }}</strong></td>
                    <td class="text-end">
    Tanggal : {{ \Carbon\Carbon::parse($nota->created_at)->format('d-m-Y') }}
</td>
                </tr>
                <tr>
                    <td colspan="2">Kepada Yth : <strong>{{ $wo->nama_pesanan }}</strong></td>
                </tr>
            </table>

            {{-- TABEL BARANG --}}
            <table class="table-nota">
                <thead>
                    <tr>
                        <th width="40">No</th>
                        <th>Nama Barang</th>
                        <th width="60">Qty</th>
                        <th width="120">Harga</th>
                        <th width="140">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no=1; @endphp
                    @foreach ($notadata as $item)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $item->barang }}</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td class="text-end">Rp {{ number_format($item->Harga,0,',','.') }}</td>
                        <td class="text-end">Rp {{ number_format($item->total,0,',','.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- TOTAL --}}
            <div class="total-container">
                <table width="100%">
                    <tr>
                        <td width="60%" rowspan="3" style="vertical-align: top; padding-top: 20px;">
                            <strong>Penerima,</strong><br><br>
                            (_____________________)
                        </td>
                        <td width="15%">Total</td>
                        <td class="text-end">Rp {{ number_format($wo->harga,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td>Deposit</td>
                        <td class="text-end">Rp {{ number_format($pembayaran->deposit,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Sisa</strong></td>
                        <td class="text-end"><strong>Rp {{ number_format($pembayaran->sisapembayaran,0,',','.') }}</strong></td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>

<style>
/* ===================== */
/* TAMPILAN LAYAR (Frontend) */
/* ===================== */
.nota-box {
    background: #fff;
    padding: 20px;
    border: 1px solid #eee;
    max-width: 850px;
    margin: 10px auto;
}

/* ===================== */
/* MODE PRINT – DOT MATRIX */
/* ===================== */
@media print {

    @page {
        size: A4 portrait;
        margin: 10mm;
    }

    /* HILANGKAN TEMPLATE */
    .main-sidebar, .sidebar, .main-header, .navbar,
    .main-footer, footer, aside,
    .no-print, .btn, .breadcrumb, .content-header {
        display: none !important;
    }

    /* RESET TOTAL */
    html, body {
        margin: 0 !important;
        padding: 0 !important;
        height: auto !important;
    }

    body,
    .content-wrapper,
    .container-fluid,
    .content,
    .print-area-wrapper,
    .nota-box,
    .nota-inner {
        margin: 0 auto !important;
        padding: 0 !important;
        width: 100% !important;
        height: auto !important;
        min-height: 0 !important;
        position: static !important;
    }

    /* PAKSA KE TENGAH (ANTI NYAMPING) */
    .nota-box {
        margin-left: auto !important;
        margin-right: auto !important;
        border: none !important; /* Hapus border kotak saat print */
    }

    body {
        font-family: "Courier New", Courier, monospace !important;
        font-size: 13pt !important;
        font-weight: bold !important;
        color: #000 !important;
    }

    table {
        width: 100% !important;
        border-collapse: collapse !important;
        page-break-inside: auto;
    }

    tr {
        page-break-inside: avoid;
    }

    .table-nota {
        margin-bottom: 0 !important; /* Mepetkan tabel barang ke bawah */
    }

    .table-nota th,
    .table-nota td {
        border: 1px solid #000 !important;
        padding: 5px 4px !important;
    }

    .nota-header {
        text-align: center;
        border-bottom: 2px solid #000;
        margin-bottom: 8px;
        padding-bottom: 5px;
    }

    /* MODIFIKASI AGAR MEPEET KE ATAS */
    .total-container {
        margin-top: 0 !important; /* Menghilangkan jarak antar tabel */
        border-top: 2px solid #000;
        padding-top: 2px !important; /* Jarak minimal setelah garis */
        page-break-inside: avoid;
    }

    .total-container td {
        padding-top: 2px !important;
        padding-bottom: 2px !important;
    }

    /* Paksa kolom "Penerima" mengabaikan padding inline 20px saat print */
    .total-container td[rowspan="3"] {
        padding-top: 0 !important;
        vertical-align: top !important;
    }

    * {
        box-shadow: none !important;
        float: none !important;
    }
}
</style>
@endsection