@extends('Admin.template.main')

@section('judul')
    Laporan Laba Rugi
@endsection

@section('Judulisi')
    <h2 class="no-print">Laporan Laba Rugi</h2>
@endsection

@section('Content1')

{{-- ===================== PRINT CSS OPTIMIZED (PORTRAIT + NO URL) ===================== --}}
<style>
@media print {
    /* 1. Atur Kertas Portrait & Margin Browser */
    @page {
        size: A4 portrait;
        margin: 10mm; 
    }

    /* 2. Paksa Sembunyikan Header/Footer/URL Bawaan Browser */
    html, body {
        height: auto;
        background-color: #fff !important;
    }

    /* 3. Sembunyikan Sidebar, Navbar, dan Elemen UI Admin Template */
    .main-sidebar, .sidebar, .main-header, .navbar, .main-footer, footer, 
    .no-print, aside, header, nav, .topbar, .btn, .breadcrumb, .content-header {
        display: none !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* 4. Reset Wrapper Template (Penting agar konten dari pojok kiri) */
    .content-wrapper, .main-content, .container-fluid, .content, .container, .card {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        position: relative !important;
        left: 0 !important;
        top: 0 !important;
        border: none !important;
        box-shadow: none !important;
        background: none !important;
    }

    /* 5. Font & Area Cetak (Dot Matrix Style) */
    .print-area {
        width: 100% !important;
        font-family: "Courier New", Courier, monospace !important;
        font-size: 15pt !important;
        font-weight: bolder !important;
        color: #000 !important;
    }

    /* 6. Tabel Agar Tidak Terpotong */
    table {
        width: 100% !important;
        border-collapse: collapse !important;
        table-layout: fixed !important;
    }

    th, td {
        border: 1px solid #000 !important;
        padding: 4px 6px !important;
        word-wrap: break-word !important;
        overflow: hidden !important;
    }

    th {
        text-align: center !important;
        font-weight: bold !important;
    }

    td.text-right {
        text-align: right !important;
    }

    center {
        margin-bottom: 15px;
        font-weight: bold;
    }

    /* Hilangkan URL/Footer Paksa */
    body:after, body:before {
        content: none !important;
        display: none !important;
    }
}

/* Styling Layar Normal (Tetap Menjaga UX Asli) */
.print-area { padding: 20px; background: #fff; }
</style>

<div class="print-area">

    <center> 
        <h4 style="margin:0;">Laba Rugi Duta Utama Grafika</h4>
        Periode: {{ $tanggal['tanggalAwal'] }} s/d {{ $tanggal['tanggalAkhir'] }}
    </center>

    <button class="btn btn-primary mb-2 no-print" onclick="window.print()">
        <i class="fas fa-print"></i> Print Laporan
    </button>

    <table class="table table-bordered small">
        <thead>
            <tr class="bg-light">
                <th width="70%">Keterangan</th>
                <th width="30%">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>

            {{-- PENDAPATAN --}}
            <tr>
                <td><strong>PENDAPATAN</strong></td>
                <td></td>
            </tr>

            @php $totalPendapatan = 0; @endphp
            @foreach($akun as $a)
                @if(strtolower($a->keterangan) == 'income')
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $a->nama }}</td>
                        <td class="text-right">Rp {{ number_format($a->saldo,0,',','.') }}</td>
                    </tr>
                    @php $totalPendapatan += $a->saldo; @endphp
                @endif
            @endforeach

            <tr class="table-secondary" style="background-color: #f4f4f4 !important;">
                <td><strong>Total Pendapatan</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalPendapatan,0,',','.') }}</strong></td>
            </tr>

            {{-- Spasi Cetak --}}
            <tr style="border: none;"><td colspan="2" style="border: none; padding: 5px;"></td></tr>

            {{-- BEBAN --}}
            <tr>
                <td><strong>BEBAN</strong></td>
                <td></td>
            </tr>

            @php $totalBeban = 0; @endphp
            @foreach($akun as $a)
                @if(strtolower($a->keterangan) == 'expense')
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $a->nama }}</td>
                        <td class="text-right">Rp {{ number_format($a->saldo,0,',','.') }}</td>
                    </tr>
                    @php $totalBeban += $a->saldo; @endphp
                @endif
            @endforeach

            <tr class="table-secondary" style="background-color: #f4f4f4 !important;">
                <td><strong>Total Beban</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalBeban,0,',','.') }}</strong></td>
            </tr>

            {{-- Spasi Cetak --}}
            <tr style="border: none;"><td colspan="2" style="border: none; padding: 10px;"></td></tr>

            {{-- LABA / RUGI --}}
            @php $labaRugiBersih = $totalPendapatan - $totalBeban; @endphp

            <tr class="table-info" style="background-color: #d1ecf1 !important;">
                <td><strong>{{ $labaRugiBersih >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' }}</strong></td>
                <td class="text-right">
                    <strong>Rp {{ number_format(abs($labaRugiBersih),0,',','.') }}</strong>
                </td>
            </tr>

        </tbody>
    </table>

    {{-- Tanda Tangan (Opsional saat print) --}}
    <div class="d-none d-print-block mt-5">
        <table width="100%" style="border: none !important;">
            <tr style="border: none !important;">
                <td style="border: none !important; width: 70%;"></td>
                <td style="border: none !important; text-align: center;">
                    Dicetak pada: {{ date('d-m-Y') }}<br><br><br><br>
                    ( ..................... )<br>
                    Admin Keuangan
                </td>
            </tr>
        </table>
    </div>

</div>

@endsection