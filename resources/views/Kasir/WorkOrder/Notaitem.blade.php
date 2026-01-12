@extends('Kasir.template.main')

@section('judul')
    Tambah Nota
@endsection

@section('tittleCard')
    <h2>Tambah Nota</h2>
@endsection

@section('Content1')

{{-- ALERT --}}
@if (session()->has('msgdone'))
<script>
Swal.fire({ title: "Berhasil", text: "Berhasil Tambah Barang", icon: "success" });
</script>
@endif

@if (session()->has('msgdoneEdt'))
<script>
Swal.fire({ title: "Berhasil", text: "Berhasil Edit Barang", icon: "success" });
</script>
@endif

@if (session()->has('msgdonehps'))
<script>
Swal.fire({ title: "Berhasil", text: "Berhasil Dihapus", icon: "success" });
</script>
@endif

@if (session()->has('errorinv'))
<script>
Swal.fire({ title: "Gagal", text: "Tambahkan Inventory Yang Keluar Terlebih Dahulu", icon: "error" });
</script>
@endif

@if(session('msgerror'))
<div class="alert alert-danger">
    {{ session('msgerror') }}
</div>
@endif

<div class="container mt-4">

<form action="/Kasir/Sales/InputNota" method="POST">
@csrf

{{-- ================= DETAIL WO ================= --}}
<div class="card shadow-lg border-0 rounded-3" id="printArea">
    <div class="card-header bg-primary text-white no-print">
        <h5 class="mb-0">Detail Work Order</h5>
    </div>

    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-sm table-striped">
                    <tr><th>Diterima Tgl</th><td>{{ $datawo->diterimaTanggal }}</td></tr>
                    <tr><th>Selesai Tgl</th><td>{{ $datawo->selesaiTanggal }}</td></tr>
                    <tr><th>Nama Pemesan</th><td>{{ $datawo->nama_pesanan }}</td></tr>
                    <tr><th>Jenis Pesanan</th><td>{{ $datawo->jenis_pesanan }}</td></tr>
                    <tr><th>Jumlah Pesanan</th><td>{{ $datawo->jumlah_pesanan }}</td></tr>
                </table>
            </div>

            <div class="col-md-6">
                <table class="table table-sm table-striped">
                    <tr><th>Ukuran Cetak</th><td>{{ $datawo->ukuran_cetak }}</td></tr>
                    <tr><th>Status Order</th><td>{{ $datawo->statusorder }}</td></tr>
                    <tr><th>Plat</th><td>{{ $datawo->plat }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<br>
<h2>Nota</h2>

{{-- ================= HIDDEN GLOBAL ================= --}}
<input type="hidden" name="idwo" value="{{ $datawo->id }}">
<input type="hidden" name="nonota" value="{{ $nonota }}">

<table class="table table-bordered" id="tableInput">
<thead>
<tr>
    <th>Nama Barang</th>
    <th>Jumlah</th>
    <th>Harga</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody id="tbodyInput">

<tr>
    <td>
        <input type="text" name="items[0][barang]" class="form-control">
    </td>

    <td>
        <input type="number" name="items[0][jumlah]" class="form-control" required>
    </td>

    <td>
        <input type="number" name="items[0][harga]" class="form-control" required>
    </td>

    {{-- FK --}}
    <input type="hidden" name="items[0][nomorwo]" value="{{ $datawo->id }}">
    <input type="hidden" name="items[0][nonota]" value="{{ $nonota }}">

    <td>
        <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
    </td>
</tr>

</tbody>
</table>

<button type="button" class="btn btn-primary mb-3" id="addRow">+</button>

<div class="row">
    <div class="col-md-6">
        <label>Metode Bayar</label>
        <select required name="metodebayar" class="form-control">
            <option value="">Pilih Metode</option>
            @foreach($datametodebayar as $d)
                <option value="{{ $d->id }}">{{ $d->nama_metode }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <label>Deposit</label>
        <input type="number" class="form-control" id="deposit" name="deposit" value="0">
    </div>

    <div class="col-md-6">
        <label>Total</label>
        <input type="text" class="form-control" id="total" name="total" readonly>
    </div>
</div>

<br>
<button type="submit" class="btn btn-success">Simpan</button>
</form>
</div>

{{-- ================= JS ================= --}}
<script>
let rowIndex = 1;

document.getElementById('addRow').addEventListener('click', function () {
    const tbody = document.getElementById('tbodyInput');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td><input type="text" name="items[${rowIndex}][barang]" class="form-control"></td>
        <td><input type="number" name="items[${rowIndex}][jumlah]" class="form-control" required></td>
        <td><input type="number" name="items[${rowIndex}][harga]" class="form-control" required></td>

        <input type="hidden" name="items[${rowIndex}][nomorwo]" value="{{ $datawo->id }}">
        <input type="hidden" name="items[${rowIndex}][nonota]" value="{{ $nonota }}">

        <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
    `;

    tbody.appendChild(row);
    rowIndex++;
});

document.getElementById('tbodyInput').addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-row')) {
        e.target.closest('tr').remove();
        hitungTotal();
    }
});

function hitungTotal() {
    let total = 0;
    document.querySelectorAll('#tbodyInput tr').forEach(row => {
        let j = row.querySelector('input[name*="[jumlah]"]').value || 0;
        let h = row.querySelector('input[name*="[harga]"]').value || 0;
        total += j * h;
    });
    document.getElementById('total').value = total;
}

document.getElementById('tbodyInput').addEventListener('input', hitungTotal);
document.getElementById('deposit').addEventListener('input', hitungTotal);
</script>

@endsection
