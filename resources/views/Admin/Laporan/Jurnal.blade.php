@extends('Admin.template.main')

@section('judul')
    Jurnal Umum
@endsection

@section('Judulisi')
    <h2>Jurnal Umum</h2>
@endsection

@section('Content1')

{{-- ===================== PRINT CSS DOT MATRIX ===================== --}}
<style>
@media print {
tr {
    page-break-inside: avoid !important; /* Biar satu transaksi nggak kepotong pindah halaman */
}
thead {
    display: table-header-group !important; /* Judul kolom muncul lagi di tiap halaman baru */
}
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

    /* PRINT AREA FULL */
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
        border: 3px solid #000 !important;
        padding: 3px 5px !important;
        white-space: nowrap !important;
        font-weight: normal !important;
    }

    th {
        text-align: center !important;
        font-weight: bold !important;
        background: none !important;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background: none !important;
    }

    td.text-right {
        text-align: right !important;
    }

    td.text-center {
        text-align: center !important;
    }

    h2, h3, p {
        text-align: center;
        margin: 0;
        padding: 2px 0;
        font-weight: bold;
    }

    tfoot td {
        font-weight: bold !important;
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
    Jurnal Umum Duta Utama Grafika<br>
    Periode: {{ $tanggalAwal }} s/d {{ $tanggalAkhir }} <br>
   </center>
    <button class="btn btn-primary mb-2 no-print" onclick="window.print()">Print Laporan</button>

    <table class="table table-bordered table-striped small">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Akun</th>
                <th>Referensi</th>
                <th>Debet</th>
                <th>Kredit</th>
            </tr>
        </thead>

       <tbody>
    @php
        $debittotal = 0;
        $kredittotal = 0;
    @endphp

    @foreach ($Jurnal as $idnota => $items)
        @foreach ($items as $index => $data)
            @php
                // Kalkulasi Total
                $debittotal += $data->debit;
                $kredittotal += $data->kredit;

                // Format Tanggal
                try {
                    $tanggal = $data->created_at instanceof \Carbon\Carbon
                        ? $data->created_at->format('d-m-Y')
                        : \Carbon\Carbon::parse($data->created_at)->format('d-m-Y');
                } catch (\Exception $e) {
                    $tanggal = $data->created_at ?? '-';
                }
            @endphp

            <tr>
                {{-- Hanya tampilkan Tanggal dan Nota di baris pertama setiap grup --}}
                @if($index == 0)
                    <td style="vertical-align: top; font-weight: bold;">{{ $tanggal }}</td>
                    <td style="font-weight: bold;">{{ $data->idakun->nama ?? '-' }}</td>
                    <td class="text-center" style="vertical-align: top; font-weight: bold;">{{ $idnota }}</td>
                @else
                    <td></td> {{-- Tanggal Kosong --}}
                    {{-- Beri indentasi/spasi pada akun Kredit agar lebih rapi --}}
                    <td style="{{ $data->kredit > 0 ? 'padding-left: 30px;' : '' }}">
                        {{ $data->idakun->nama ?? '-' }}
                    </td>
                    <td></td> {{-- Nota Kosong --}}
                @endif

                <td class="text-right">
                    {{ $data->debit > 0 ? 'Rp ' . number_format($data->debit, 0, ',', '.') : '-' }}
                </td>
                <td class="text-right">
                    {{ $data->kredit > 0 ? 'Rp ' . number_format($data->kredit, 0, ',', '.') : '-' }}
                </td>
            </tr>
        @endforeach
        {{-- Opsional: Tambah baris kosong tipis antar group transaksi --}}
        <tr class="no-print" style="background-color: #f9f9f9;"><td colspan="5" style="padding: 2px; border: none;"></td></tr>
    @endforeach
</tbody>

        <tfoot>
            <tr>
                <td colspan="3" class="text-center">Total</td>
                <td class="text-right">Rp {{ number_format($debittotal, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($kredittotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

</div>

@endsection
