@extends('Admin.template.main')

@section('judul')
   Pelunasan Nota Bpk/Ibu 
@endsection

@section('Judulisi')
    <h2>Pelunasan Bpk/Ibu {{ $wo->nama_pesanan }}</h2>
@endsection

@section('Content1')

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
                            <td class="text-end"><b id="sisaPembayaran" data-sisa="{{ $pembayaran->sisapembayaran }}">
                                Rp {{ number_format($pembayaran->sisapembayaran, 0, ',', '.') }}
                            </b></td>
                        </tr>
                    </table>

                    {{-- Input Pelunasan --}}
                    <form method="POST" action="/Admin/Sales/Pelunasan">
                        @csrf
                        <div class="mb-2">
                            <label for="bayar" class="form-label fw-bold">Jumlah Pelunasan</label>
                            <input type="text" hidden name = "totalharganota" value="{{ $wo->harga }}">
                            <input type="text" hidden name = "idnota" value="{{ $nota->nonota  }}">
                              <input type="text" hidden name = "deposit" value="{{ $pembayaran->deposit  }}">
                            <input type="text" hidden name = "sisabayar" value="{{ $pembayaran->sisapembayaran  }}" >

                            <input type="number" class="form-control form-control-sm text-end" 
                                   id="bayar" name="bayaransekarang" placeholder="Masukkan jumlah (Rp)">
                            <small id="warning" class="text-danger d-none">
                                ❌ Jumlah pelunasan tidak boleh melebihi sisa pembayaran!
                            </small>
                        </div>
                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-sm mt-2">Simpan</button>
                    </form>

                    <p class="mt-4">Duta Utama Grafika</p>
                </div>
            </div>
        </div>
    </div>


<style>
@media print {
     .sidebar, .navbar, .no-print {
        display: none !important;
    }
    .content-wrapper, .container, .card {
        margin: 0 !important;
        width: 100% !important;
        box-shadow: none !important;
    }
    body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        font-size: 13px;
        background: #fff !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    .container {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
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

{{-- Script Validasi --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    const bayarInput   = document.getElementById("bayar");
    const warning      = document.getElementById("warning");
    const btnSubmit    = document.getElementById("btnSubmit");
    const sisaPembayaran = parseInt(document.getElementById("sisaPembayaran").dataset.sisa);

    bayarInput.addEventListener("input", function() {
        const bayar = parseInt(bayarInput.value) || 0;

        if (bayar > sisaPembayaran) {
            warning.classList.remove("d-none");
            btnSubmit.disabled = true;
        } else {
            warning.classList.add("d-none");
            btnSubmit.disabled = false;
        }
    });
});
</script>
@endsection
