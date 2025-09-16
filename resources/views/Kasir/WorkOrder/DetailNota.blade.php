@extends('Kasir.template.main')

@section('judul')
    Nota Bpk/Ibu 
@endsection

@section('Judulisi')
    <h2>Nota Bpk/Ibu {{ $wo->nama_pesanan }}</h2>
@endsection

@section('Content1')
<div class="container my-4">
    <div class="d-flex justify-content-end mb-3 no-print">
        <button class="btn btn-success btn-sm me-2" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print
                </button>
    </div>

    <div class="card shadow rounded-3">
        <div class="card-body" id="nota-content">
            <div class="row">
                <div class="col-6">
                    <h5 class="fw-bold">Duta Utama Grafika</h5>
                    <p class="mb-0">Jl TK Irawadi 66 Panjer, Denpasar</p>
                    <p class="mb-0">Telp: 0361 244061, 8083976, 8955186</p>
                </div>
                <div class="col-6 text-end">
                    <p class="mb-0">Denpasar, {{ $nota->created_at->format('d-m-Y') }}</p>
                    <p class="mb-0">No Nota: <strong>{{ $nota->nonota }}</strong></p>
                    <p class="mb-0">Kpd Yth: <strong>{{ $wo->nama_pesanan }}</strong></p>
                </div>
            </div>
            
            <hr>

            <table class="table table-bordered table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Barang</th>
                        <th style="width: 10%;">Qty</th>
                        <th style="width: 20%;">Harga</th>
                        <th style="width: 20%;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($notadata as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->barang }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp {{ number_format($item->Harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row mt-3">
                <div class="col-6">
                    <p><strong>Penerima</strong></p>
                    <br><br>
                    <p>_____________________</p>
                </div>
                <div class="col-6 text-end">
                    <table class="table table-borderless">
                        <tr>
                            <th>Total</th>
                            <td class="text-end">Rp {{ number_format($wo->harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Deposit</th>
                            <td class="text-end"><b>Rp {{ number_format($pembayaran->deposit, 0, ',', '.') }}</b></td>
                        </tr>
                        <tr>
                            <th>Sisa</th>
                            <td class="text-end"><b>Rp {{ number_format($pembayaran->sisapembayaran, 0, ',', '.') }}</b></td>
                        </tr>
                    </table>
                    <p class="mt-4">Duta Utama Grafika</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {

     .sidebar, .navbar, .no-print {
        display: none !important;   /* Sembunyikan sidebar & navbar */
    }
    .content-wrapper, .container, .card {
        margin: 0 !important;
        width: 100% !important;     /* Biar full lebar halaman */
        box-shadow: none !important;
    }

    body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        font-size: 13px;
         background: #fff !important;
    }

    .no-print {
        display: none !important;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }

    /* Hilangin margin container biar full ke kertas */
    .container {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Tambahin footer otomatis di bawah print */
    body:after {
        content: "Dicetak pada: {{ date('d-m-Y H:i') }}";
        display: block;
        text-align: center;
        margin-top: 30px;
        font-size: 11px;
        color: #555;
    }
}
</style>
@endsection
