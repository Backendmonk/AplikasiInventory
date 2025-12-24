@extends('Admin.template.main')

@section('judul')
    Nota Bpk/Ibu
@endsection

@section('Content1')
<div class="print-area-wrapper">

    {{-- TOMBOL PRINT (Hanya muncul di layar laptop) --}}
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
                    <td style="width: 55%">No Nota : <strong>{{ $nota->nonota }}</strong></td>
                    <td class="text-end">Tanggal : {{ $nota->created_at->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td colspan="2">Kepada Yth : <strong>{{ $wo->nama_pesanan }}</strong></td>
                </tr>
            </table>

            {{-- TABEL BARANG --}}
            <table class="table-nota">
                <thead>
                    <tr>
                        <th style="width: 40px">No</th>
                        <th>Nama Barang</th>
                        <th style="width: 60px">Qty</th>
                        <th style="width: 120px">Harga</th>
                        <th style="width: 140px">Jumlah</th>
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

            {{-- TOTAL & PENERIMA --}}
            <div class="total-container">
                <table width="100%">
                    <tr>
                        <td width="60%" rowspan="3" style="vertical-align: top; padding-top: 25px;">
                            <strong>Penerima,</strong><br><br><br><br>
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
/* --- TAMPILAN LAYAR --- */
.nota-box { 
    background: #fff; 
    padding: 30px; 
    border: 1px solid #eee; 
    max-width: 850px; 
    margin: 20px auto; 
}

/* --- TAMPILAN PRINT --- */
@media print {
    @page {
        size: A4 portrait;
        margin: 10mm; /* Mengurangi margin agar area cetak lebih luas */
    }

    /* Hilangkan sidebar, navbar, dan footer template secara total */
    .main-sidebar, .sidebar, .main-header, .navbar, .main-footer, footer, 
    .no-print, aside, header, .btn, .breadcrumb, .content-header, .footer-timestamp {
        display: none !important;
    }

    /* Reset Wrapper agar ke pojok kiri atas */
    body, .content-wrapper, .main-content, .container-fluid, .content {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        position: relative !important;
    }

    body {
        font-family: "Courier New", Courier, monospace !important;
        font-size: 15pt !important;
        font-weight: bolder !important;
    }

    .table-nota {
        width: 100% !important;
        border-collapse: collapse !important;
        table-layout: fixed !important;
    }

    .table-nota th, .table-nota td {
        border: 1px solid #000 !important;
        padding: 6px 4px !important;
    }

    .nota-header {
        text-align: center;
        border-bottom: 2px solid #000;
        margin-bottom: 10px;
    }

    .total-container {
        margin-top: 20px;
        border-top: 2px solid #000;
        padding-top: 10px;
    }
}
</style>
@endsection