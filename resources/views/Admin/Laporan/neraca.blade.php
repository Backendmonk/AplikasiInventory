@extends('Admin.template.main')

@section('judul')
    Laporan Neraca
@endsection

@section('Judulisi')
    <h2>Laporan Neraca</h2>
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
    <h3 class="text-center mb-4">Laporan Neraca<br>Nama Perusahaan Anda<br></h3>
    
    {{-- Tombol print tidak ikut tercetak --}}
    <button class="btn btn-primary mb-3 no-print" onclick="window.print()">Print Laporan</button>

    <h4 class="mb-3">Neraca</h4>
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Akun</th>
                <th class="text-end">Debet (Rp)</th>
                <th class="text-end">Kredit (Rp)</th>
            </tr>
        </thead>
        <tbody>
            {{-- ASET --}}
            <tr class="table-secondary">
                <td><strong>ASET</strong></td>
                <td></td>
                <td></td>
            </tr>
            @php $totalAset = 0; @endphp
            @foreach($akun as $a)
                @if(strtolower($a->keterangan) == 'asset') 
                    @if($a->saldo >= 0)
                        <tr>
                            <td>&nbsp;&nbsp;{{ $a->nama }}</td>
                            {{-- Mengubah format uang dari Rp.{{...}} menjadi {{...}} agar lebih rapi di tabel --}}
                            <td class="text-end">Rp.{{ number_format($a->saldo,0,',','.') }}</td>
                            <td></td>
                        </tr>
                        @php $totalAset += $a->saldo; @endphp
                    @endif
                @endif
            @endforeach
            <tr class="fw-bold">
                <td>Total Aset</td>
                <td class="text-end">Rp.{{ number_format($totalAset,0,',','.') }}</td>
                <td></td>
            </tr>

            {{-- LIABILITAS --}}
            <tr class="table-secondary">
                <td><strong>LIABILITAS</strong></td>
                <td></td>
                <td></td>
            </tr>
            @php $totalLiab = 0; @endphp
            @foreach($akun as $a)
                @if(strtolower($a->keterangan) == 'liability') 
                    @if($a->saldo >= 0)
                        <tr>
                            <td>&nbsp;&nbsp;{{ $a->nama }}</td>
                            <td></td>
                            <td class="text-end">Rp.{{ number_format($a->saldo,0,',','.') }}</td>
                        </tr>
                        @php $totalLiab += $a->saldo; @endphp
                    @endif
                @endif
            @endforeach
            <tr class="fw-bold">
                <td>Total Liabilitas</td>
                <td></td>
                <td class="text-end">Rp.{{ number_format($totalLiab,0,',','.') }}</td>
            </tr>

            {{-- EKUITAS --}}
            <tr class="table-secondary">
                <td><strong>EKUITAS</strong></td>
                <td></td>
                <td></td>
            </tr>
            @php $totalEquity = 0; @endphp
            @foreach($akun as $a)
                @if(strtolower($a->keterangan) == 'equity')
                    @if($a->saldo >= 0)
                        <tr>
                            <td>&nbsp;&nbsp;{{ $a->nama }}</td>
                            <td></td>
                            <td class="text-end">Rp.{{ number_format($a->saldo,0,',','.') }}</td>
                        </tr>
                        @php $totalEquity += $a->saldo; @endphp
                    @endif
                @endif
            @endforeach
            <tr class="fw-bold">
                <td>Total Ekuitas</td>
                <td></td>
                <td class="text-end">Rp.{{ number_format($totalEquity,0,',','.') }}</td>
            </tr>

            {{-- TOTAL LIABILITAS + EKUITAS --}}
            <tr class="table-success fw-bold">
                <td>Total Liabilitas + Ekuitas</td>
                {{-- Kolom Debet menampilkan Total Aset --}}
                <td class="text-end">Rp.{{ number_format($totalAset,0,',','.') }}</td> 
                {{-- Kolom Kredit menampilkan Total Liabilitas + Ekuitas --}}
                <td class="text-end">Rp.{{ number_format($totalLiab + $totalEquity,0,',','.') }}</td>
            </tr>
        </tbody>
    </table>
</div>
{{-- ===================== PRINT-AREA END ===================== --}}

@endsection