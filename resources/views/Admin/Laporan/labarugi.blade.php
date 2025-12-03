@extends('Admin.template.main')

@section('judul')
    Laporan Laba Rugi
@endsection

@section('Judulisi')
    <h2>Laporan Laba Rugi</h2>
@endsection

@section('Content1')

{{-- ===================== PRINT CSS ===================== --}}
<style>
@media print {
    /* Sembunyikan semua elemen di luar print-area */
    .no-print,
    header,
    nav,
    aside,
    .sidebar,
    .main-header,
    .main-sidebar,
    .footer,
    .navbar,
    .content-header,
    .topbar {
        display: none !important;
    }

    /* Pastikan print-area full width dan di tengah */
    .print-area {
        width: 100% !important;
        margin: 0 auto !important;
    }
    
    /* Atur tampilan tabel untuk cetak */
    .table-bordered {
        border-collapse: collapse !important;
    }
    .table-bordered th, 
    .table-bordered td {
        border: 1px solid #000 !important;
        padding: 8px;
    }
}
</style>

{{-- ===================== PRINT-AREA START ===================== --}}
<div class="container my-4 print-area">
    <h3 class="text-center mb-4">Laporan Laba Rugi<br>Nama Perusahaan Anda<br></h3>
    
    {{-- Tombol print tidak ikut tercetak --}}
    <button class="btn btn-primary mb-3 no-print" onclick="window.print()">Print Laporan</button>

    <h4 class="mb-3">Laba Rugi</h4>
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Keterangan</th>
                <th class="text-end">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            {{-- PENDAPATAN --}}
            <tr class="table-secondary">
                <td><strong>PENDAPATAN</strong></td>
                <td></td>
            </tr>
            @php $totalPendapatan = 0; @endphp
            @foreach($akun as $a)
                {{-- Filter akun Pendapatan --}}
                @if(strtolower($a->keterangan) == 'income') 
                    <tr>
                        <td>&nbsp;&nbsp;{{ $a->nama }}</td>
                        <td class="text-end">Rp.{{ number_format($a->saldo,0,',','.') }}</td>
                    </tr>
                    @php $totalPendapatan += $a->saldo; @endphp
                @endif
            @endforeach
            <tr class="fw-bold">
                <td>Total Pendapatan</td>
                <td class="text-end border-top border-dark border-2">Rp.{{ number_format($totalPendapatan,0,',','.') }}</td>
            </tr>

            {{-- BEBAN --}}
            <tr class="table-secondary">
                <td><strong>BEBAN</strong></td>
                <td></td>
            </tr>
            @php $totalBeban = 0; @endphp
            @foreach($akun as $a)
                {{-- Filter akun Beban --}}
                @if(strtolower($a->keterangan) == 'expense') 
                    <tr>
                        <td>&nbsp;&nbsp;{{ $a->nama }}</td>
                        {{-- Beban ditampilkan sebagai nilai positif, namun dihitung sebagai pengurang --}}
                        <td class="text-end">Rp.{{ number_format($a->saldo,0,',','.') }}</td>
                    </tr>
                    @php $totalBeban += $a->saldo; @endphp
                @endif
            @endforeach
            <tr class="fw-bold">
                <td>Total Beban</td>
                <td class="text-end border-top border-dark border-2">Rp.{{ number_format($totalBeban,0,',','.') }}</td>
            </tr>

            {{-- LABA/RUGI BERSIH --}}
            @php $labaRugiBersih = $totalPendapatan - $totalBeban; @endphp

            <tr class="table-info fw-bold">
                <td>{{ $labaRugiBersih >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}</td>
                <td class="text-end border-top border-dark border-3">
                    Rp.{{ number_format(abs($labaRugiBersih),0,',','.') }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
{{-- ===================== PRINT-AREA END ===================== --}}

@endsection