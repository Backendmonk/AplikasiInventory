@extends('Admin.template.main')

@section('judul')
    Laporan Neraca
@endsection

@section('Judulisi')
    <h2 class="no-print">Laporan Neraca</h2>
@endsection

@section('Content1')

{{-- ===================== PRINT CSS OPTIMIZED (PORTRAIT + NO URL) ===================== --}}
<style>
@media print {
    /* 1. Paksa Orientasi Portrait & Hilangkan Header/Footer Browser */
    @page {
        size: A4 portrait;
                margin: 3mm 6mm; /* Margin ini menekan URL keluar dari area cetak */
    }

    /* 2. Sembunyikan Elemen UI Web */
    .no-print, nav, header, aside, .sidebar, .navbar, .topbar, footer, 
    .btn, .breadcrumb, .content-header, .main-footer {
        display: none !important;
        height: 0 !important;
    }

    /* 3. Reset Container agar Full Width & Tidak Terpotong */
    body, .content-wrapper, .main-content, .container-fluid, .content, .container, .card {
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

    /* 4. Font & Area Cetak (Dot Matrix Friendly) */
    .print-area {
        width: 100% !important;
        font-family: "Courier New", Courier, monospace !important;
        font-size: 15pt !important;
        font-weight: bolder !important;
        color: #000 !important;
    }

    /* 5. Tabel Cetak */
    table {
        width: 100% !important;
        border-collapse: collapse !important;
        table-layout: fixed !important; /* Mencegah tabel meluber ke samping */
    }

    th, td {
        border: 1px solid #000 !important;
        padding: 4px 6px !important;
        word-wrap: break-word !important;
    }

    th {
        text-align: center !important;
        font-weight: bold !important;
        background-color: #f2f2f2 !important;
        -webkit-print-color-adjust: exact;
    }

    td.text-right {
        text-align: right !important;
    }

    /* Hilangkan URL paksa pada browser Chrome/Edge */
    body:after, body:before {
        content: none !important;
        display: none !important;
    }
}

/* Styling Layar Normal (UX Asli) */
.print-area { padding: 20px; }
</style>

<div class="print-area">

    <center> 
        <h3 style="margin:0; font-weight: bold;">Neraca Duta Utama Grafika</h3>
        Periode: {{ $tanggal['tanggalAwal'] }} s/d {{ $tanggal['tanggalAkhir'] }}
    </center>

    <button class="btn btn-primary mb-3 no-print" onclick="window.print()">
        <i class="fas fa-print"></i> Print Laporan
    </button>

    <table class="table table-bordered small">
        <thead>
            <tr>
                <th width="50%">Akun</th>
                <th width="25%">Debet (Rp)</th>
                <th width="25%">Kredit (Rp)</th>
            </tr>
        </thead>
        <tbody>

            {{-- ASET --}}
            <tr style="background-color: #f9f9f9;">
                <td><strong>ASET</strong></td>
                <td></td>
                <td></td>
            </tr>

            @php $totalAset = 0; @endphp
            @foreach($akun as $a)
                @if(strtolower($a->keterangan) == 'asset' && $a->saldo >= 0)
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $a->nama }}</td>
                        <td class="text-right">Rp {{ number_format($a->saldo,0,',','.') }}</td>
                        <td></td>
                    </tr>
                    @php $totalAset += $a->saldo; @endphp
                @endif
            @endforeach

            <tr style="font-weight: bold;">
                <td>Total Aset</td>
                <td class="text-right">Rp {{ number_format($totalAset,0,',','.') }}</td>
                <td></td>
            </tr>

            {{-- Spasi --}}
            <tr style="border:none;"><td colspan="3" style="border:none; padding: 5px;"></td></tr>

            {{-- LIABILITAS --}}
            <tr style="background-color: #f9f9f9;">
                <td><strong>LIABILITAS</strong></td>
                <td></td>
                <td></td>
            </tr>

            @php $totalLiab = 0; @endphp
            @foreach($akun as $a)
                @if(strtolower($a->keterangan) == 'liability' && $a->saldo >= 0)
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $a->nama }}</td>
                        <td></td>
                        <td class="text-right">Rp {{ number_format($a->saldo,0,',','.') }}</td>
                    </tr>
                    @php $totalLiab += $a->saldo; @endphp
                @endif
            @endforeach

            <tr style="font-weight: bold;">
                <td>Total Liabilitas</td>
                <td></td>
                <td class="text-right">Rp {{ number_format($totalLiab,0,',','.') }}</td>
            </tr>

            {{-- EKUITAS --}}
            <tr style="background-color: #f9f9f9;">
                <td><strong>EKUITAS</strong></td>
                <td></td>
                <td></td>
            </tr>

            @php $totalEquity = 0; @endphp
            @foreach($akun as $a)
                @if(strtolower($a->keterangan) == 'equity' && $a->saldo >= 0)
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $a->nama }}</td>
                        <td></td>
                        <td class="text-right">Rp {{ number_format($a->saldo,0,',','.') }}</td>
                    </tr>
                    @php $totalEquity += $a->saldo; @endphp
                @endif
            @endforeach

            <tr style="font-weight: bold;">
                <td>Total Ekuitas</td>
                <td></td>
                <td class="text-right">Rp {{ number_format($totalEquity,0,',','.') }}</td>
            </tr>

            {{-- Spasi --}}
            <tr style="border:none;"><td colspan="3" style="border:none; padding: 10px;"></td></tr>

            {{-- TOTAL AKHIR --}}
            <tr style="background-color: #eee !important; font-weight: bold; font-size: 12px;">
                <td>TOTAL LIABILITAS + EKUITAS</td>
                <td class="text-right">Rp {{ number_format($totalAset,0,',','.') }}</td>
                <td class="text-right">Rp {{ number_format($totalLiab + $totalEquity,0,',','.') }}</td>
            </tr>

        </tbody>
    </table>

    {{-- Tanda Tangan Cetak --}}
    <div class="d-none d-print-block mt-5">
        <table width="100%" style="border: none !important;">
            <tr style="border: none !important;">
                <td style="border: none !important; width: 60%;"></td>
                <td style="border: none !important; text-align: center;">
                    Dicetak pada: {{ date('d/m/Y H:i') }}<br><br><br><br>
                    ( ..................... )<br>
                    Bagian Keuangan
                </td>
            </tr>
        </table>
    </div>

</div>

@endsection