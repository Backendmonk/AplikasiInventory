@extends('Admin.template.main')

@section('judul')
    Jurnal Umum
@endsection

@section('Judulisi')
    <h2 class="no-print">Jurnal Umum</h2>
@endsection

@section('Content1')

{{-- ===================== PRINT CSS OPTIMIZED (PORTRAIT + NO URL) ===================== --}}
<style>
@media print {
    /* 1. Atur Kertas Portrait & Sembunyikan Header/Footer Browser */
    @page {
        size: A4 portrait;
        margin: 10mm; /* Menghilangkan margin otomatis browser yang berisi URL */
    }
     /* Hilangkan sidebar, navbar, dan footer template secara total */
    .main-sidebar, .sidebar, .main-header, .navbar, .main-footer, footer, 
    .no-print, aside, header, .btn, .breadcrumb, .content-header, .footer-timestamp {
        display: none !important;
    }

    /* 2. Sembunyikan Elemen Antarmuka Web */
    .main-sidebar, .sidebar, .main-header, .navbar, .main-footer, footer, 
    .no-print, aside, header, nav, .topbar, .btn, .breadcrumb, .content-header,
    .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
        display: none !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* 3. Reset Layout Wrapper agar tidak tergeser sidebar */
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

    /* 4. Font Styling (Khusus Dot Matrix / Nota) */
    .print-area {
        width: 100% !important;
        font-family: "Courier New", Courier, monospace !important;
        font-size: 11px !important;
        color: #000 !important;
    }

    /* 5. Tabel Formatting (Portrait & Tidak Terpotong) */
    table {
        width: 100% !important;
        border-collapse: collapse !important;
        table-layout: fixed !important; /* Kunci agar tidak meluber keluar kertas */
    }

    th, td {
        border: 1px solid #000 !important;
        padding: 4px 6px !important;
        word-wrap: break-word !important;
        overflow: hidden !important;
        color: #000 !important;
    }

    tr {
        page-break-inside: avoid !important;
    }
    
    thead {
        display: table-header-group !important;
    }

    /* Hilangkan URL/Footer Paksa */
    body:after, body:before {
        content: none !important;
        display: none !important;
    }
}

/* Tampilan Layar (UI/UX Asli) */
.print-area { padding: 20px; background: #fff; }
</style>

<div class="print-area">

    {{-- Judul Cetak (Hanya Muncul saat Print) --}}
    <div class="d-none d-print-block text-center mb-4">
        <h3 style="margin:0; font-weight: bold;">DUTA UTAMA GRAFIKA</h3>
        <h4 style="margin:0;">LAPORAN JURNAL UMUM</h4>
        <p style="margin:0;">Periode: {{ $tanggalAwal }} s/d {{ $tanggalAkhir }}</p>
        <hr style="border: 1px solid #000; margin-top: 10px;">
    </div>

    {{-- Judul Layar (Hanya Muncul di Browser) --}}
    <div class="text-center mb-4 no-print">
        <h4>Jurnal Umum Duta Utama Grafika</h4>
        <p>Periode: {{ $tanggalAwal }} s/d {{ $tanggalAkhir }}</p>
    </div>

    <button class="btn btn-primary mb-3 no-print" onclick="window.print()">
        <i class="fas fa-print"></i> Print Jurnal (Portrait)
    </button>

    <table class="table table-bordered table-striped">
        <thead>
            <tr class="bg-light">
                <th width="15%">Tanggal</th>
                <th width="35%">Nama Akun</th>
                <th width="15%">Referensi</th>
                <th width="17%">Debet</th>
                <th width="17%">Kredit</th>
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
                        $debittotal += $data->debit;
                        $kredittotal += $data->kredit;

                        try {
                            $tanggal = $data->created_at instanceof \Carbon\Carbon
                                ? $data->created_at->format('d-m-Y')
                                : \Carbon\Carbon::parse($data->created_at)->format('d-m-Y');
                        } catch (\Exception $e) {
                            $tanggal = $data->created_at ?? '-';
                        }
                    @endphp

                    <tr>
                        @if($index == 0)
                            <td style="vertical-align: top; font-weight: bold;">{{ $tanggal }}</td>
                            <td style="font-weight: bold;">{{ $data->idakun->nama ?? '-' }}</td>
                            <td class="text-center" style="vertical-align: top; font-weight: bold;">{{ $idnota }}</td>
                        @else
                            <td></td>
                            <td style="{{ $data->kredit > 0 ? 'padding-left: 25px;' : '' }}">
                                {{ $data->idakun->nama ?? '-' }}
                            </td>
                            <td class="text-center"></td>
                        @endif

                        <td class="text-right">
                            {{ $data->debit > 0 ? 'Rp ' . number_format($data->debit, 0, ',', '.') : '-' }}
                        </td>
                        <td class="text-right">
                            {{ $data->kredit > 0 ? 'Rp ' . number_format($data->kredit, 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                @endforeach
                {{-- Pemisah tipis untuk tampilan layar --}}
                <tr class="no-print"><td colspan="5" style="padding: 1px; background: #eee; border:none;"></td></tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr style="background-color: #f8f9fc; font-weight: bold;">
                <td colspan="3" class="text-center">TOTAL</td>
                <td class="text-right">Rp {{ number_format($debittotal, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($kredittotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</div>

@endsection