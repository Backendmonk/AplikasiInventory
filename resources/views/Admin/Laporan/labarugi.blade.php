@extends('Admin.template.main')

@section('judul')
    Laporan Laba Rugi
@endsection

@section('Judulisi')
    <h2>Laporan Laba Rugi</h2>
@endsection

@section('Content1')

{{-- ===================== PRINT CSS DOT MATRIX ===================== --}}
<style>
@media print {

    .no-print,
    nav, header, aside,
    .sidebar, .navbar, .topbar,
    footer {
        display: none !important;
    }

    body {
        margin: 0 !important;
        padding: 0 !important;
    }

    /* AREA CETAK */
    .print-area {
        margin: 0 !important;
        padding: 0 !important;
        font-family: "Courier New", Courier, monospace !important;
        font-size: 11px !important;
        color: #000 !important;
    }

    /* HILANGKAN CARD / CONTAINER */
    .container,
    .card,
    .card-body,
    .table-responsive {
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
    }

    /* TABLE */
    table {
        width: 100% !important;
        border-collapse: collapse !important;
    }

    th, td {
        border: 1px solid #000 !important;
        padding: 3px 5px !important;
        white-space: nowrap !important;
        font-weight: normal !important;
    }

    th {
        text-align: center !important;
        font-weight: bold !important;
        background: none !important;
    }

    /* Hilangkan warna bootstrap */
    .table-dark,
    .table-secondary,
    .table-info {
        background: none !important;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background: none !important;
    }

    td.text-end,
    td.text-right {
        text-align: right !important;
    }

    h2, h3, h4, p {
        text-align: center;
        margin: 0;
        padding: 2px 0;
        font-weight: bold;
    }

    /* DataTables OFF */
    .dataTables_length,
    .dataTables_filter,
    .dataTables_info,
    .dataTables_paginate {
        display: none !important;
    }
}
</style>

<div class="print-area">

    <center> 
    Laba Rugi Duta Utama Grafika<br>
    Periode: {{ $tanggal['tanggalAwal'] }} s/d {{ $tanggal['tanggalAkhir'] }} <br>
   </center>

    <button class="btn btn-primary mb-2 no-print" onclick="window.print()">Print Laporan</button>

    <table class="table table-bordered small">
        <thead>
            <tr>
                <th>Keterangan</th>
                <th>Jumlah (Rp)</th>
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
                        <td>&nbsp;&nbsp;{{ $a->nama }}</td>
                        <td class="text-right">Rp {{ number_format($a->saldo,0,',','.') }}</td>
                    </tr>
                    @php $totalPendapatan += $a->saldo; @endphp
                @endif
            @endforeach

            <tr>
                <td><strong>Total Pendapatan</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalPendapatan,0,',','.') }}</strong></td>
            </tr>

            {{-- BEBAN --}}
            <tr>
                <td><strong>BEBAN</strong></td>
                <td></td>
            </tr>

            @php $totalBeban = 0; @endphp
            @foreach($akun as $a)
                @if(strtolower($a->keterangan) == 'expense')
                    <tr>
                        <td>&nbsp;&nbsp;{{ $a->nama }}</td>
                        <td class="text-right">Rp {{ number_format($a->saldo,0,',','.') }}</td>
                    </tr>
                    @php $totalBeban += $a->saldo; @endphp
                @endif
            @endforeach

            <tr>
                <td><strong>Total Beban</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalBeban,0,',','.') }}</strong></td>
            </tr>

            {{-- LABA / RUGI --}}
            @php $labaRugiBersih = $totalPendapatan - $totalBeban; @endphp

            <tr>
                <td><strong>{{ $labaRugiBersih >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' }}</strong></td>
                <td class="text-right">
                    <strong>Rp {{ number_format(abs($labaRugiBersih),0,',','.') }}</strong>
                </td>
            </tr>

        </tbody>
    </table>

</div>

@endsection
