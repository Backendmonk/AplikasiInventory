@extends('Admin.template.main')

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

@if (session()->has('errorinv'))
<script>
Swal.fire({ title: "Gagal", text: "Tambahkan Inventory Yang Keluar Terlebih Dahulu", icon: "error" });
</script>
@endif

<div class="container mt-4">
<form action="/Admin/Sales/InputNota" method="POST">
@csrf

<input type="hidden" name="idwo" value="{{ $datawo->id }}">

{{-- ================= WORK ORDER ================= --}}
<div class="card shadow-lg border-0 rounded-3 mb-4">
<div class="card-header bg-primary text-white">
<h5 class="mb-0">Detail Work Order</h5>
</div>
<div class="row mb-4"> 
    <div class="col-md-6"> 
        <table class="table table-sm table-striped"> 
            <tr><th>Diterima Tgl</th><td>{{ $datawo->diterimaTanggal }}</td></tr> 
            <tr><th>Selesai Tgl</th><td>{{ $datawo->selesaiTanggal }}</td></tr> 
            <tr><th>Nama Pemesan</th><td>{{ $datawo->nama_pesanan }}</td></tr> 
            <tr><th>Jenis Pesanan</th><td>{{ $datawo->jenis_pesanan }}</td></tr> 
            <tr><th>Jumlah Pesanan</th><td>{{ $datawo->jumlah_pesanan }}</td></tr> 
            <tr><th>Jml Kertas Dicetak</th><td>{{ $datawo->jumlah_kertasdicetak }}</td></tr> 
            <tr><th>Jenis Kertas</th><td>{{ $datawo->jenis_kertas }}</td></tr> 
            <tr><th>Warna Tinta</th><td>{{ $datawo->warna_tinta }}</td></tr> 
            <tr><th>Nomorator Start</th><td>{{ $datawo->nomoratorstart }}</td></tr> 
        </table> 
    </div> 
    <div class="col-md-6"> 
        <table class="table table-sm table-striped"> 
            <tr><th>Ukuran Cetak</th><td>{{ $datawo->ukuran_cetak }}</td></tr> 
            <tr><th>Ukuran Jadi</th><td>{{ $datawo->ukuran_jadi }}</td></tr> 
            <tr><th>Rangka/Susunan</th><td>{{ $datawo->ukuran_rangkapsusun }}</td></tr> 
            <tr><th>Reproduksi</th><td>{{ $datawo->reproduksi }}</td></tr> 
            <tr><th>Sistem Jilid</th><td>{{ $datawo->sistemjilid }}</td></tr> 
            <tr><th>Status Order</th><td>{{ $datawo->statusorder }}</td></tr> 
            <tr><th>Plat</th><td>{{ $datawo->plat }}</td></tr> 
            <tr><th>Isi per Buku</th><td>{{ $datawo->isiperbuku }}</td></tr> 
        </table> 
    </div> 
</div>
</div>

<h6 class="text-primary"><i class="bi bi-list-check me-2"></i> Rincian Tambahan</h6> 
<div class="border rounded bg-light p-3"> 
    <pre class="mb-0">{{ $datawo->keterangan }}</pre> 
</div> 
<br> 
<h6 class="text-primary"><i class="bi bi-list-check me-2"></i> Inventory Digunakan</h6>
<div class="border rounded bg-light p-3"> 
    <table class="table table-bordered" width="100%" cellspacing="0"> 
        <thead> 
            <tr> 
                <th>Nama Barang</th> 
                <th>Qty Keluar</th> 
            </tr> 
        </thead> 
        <tbody> 
            @foreach ($databarangKeluar as $data) 
            <tr> 
                <td>{{ $data->databarangwo->nama_barang }}</td> 
                <td>{{ $data->qty }}</td> 
            </tr> 
            @endforeach 
        </tbody> 
    </table> 
</div> 

{{-- ================= NOTA ================= --}}
<h3 class="mt-4">Nota</h3>

<table class="table table-bordered">
<thead>
<tr>
<th>Nama Barang</th>
<th>Jumlah</th>
<th>Harga</th>
<th>Aksi</th>
</tr>
</thead>

<tbody id="tbodyInput">
<tr data-index="0">
<td>
    <input type="text" name="items[0][barang]" class="form-control" value="Ongkos Cetak" readonly required>
</td>
<td>
    <input type="number" name="items[0][jumlah]" class="form-control" value="1" required>
</td>
<td>
    <input type="number" name="items[0][harga]" class="form-control" value="0" required>
</td>
<td>
    <button type="button" class="btn btn-secondary btn-sm" disabled title="Item default tidak bisa dihapus">Hapus</button>
</td>
</tr>
</tbody>
</table>

<button type="button" class="btn btn-primary mb-3" id="addRow">+</button>

{{-- ================= PEMBAYARAN ================= --}}
<div class="row">
<div class="col-md-6">
<label>Metode Bayar</label>
<select name="metodebayar" class="form-control" required>
<option value="">Pilih Metode</option>
@foreach($datametodebayar as $m)
<option value="{{ $m->id }}">{{ $m->nama_metode }}</option>
@endforeach
</select>
</div>

<div class="col-md-6">
<label>Deposit</label>
<input type="number" class="form-control" id="deposit" name="deposit" value="0">
</div>
</div>

<div class="mt-3">
<label>Total</label>
<input type="text" class="form-control" id="total" name="total" readonly>
</div>

<button type="submit" class="btn btn-success mt-4">Simpan</button>
</form>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
let rowIndex = 1;

document.addEventListener('DOMContentLoaded', function() {
    hitungTotal();
});

document.getElementById('addRow').addEventListener('click', function () {
    const tbody = document.getElementById('tbodyInput');
    const row = document.createElement('tr');
    row.setAttribute('data-index', rowIndex);

    row.innerHTML = `
        <td><input type="text" name="items[${rowIndex}][barang]" class="form-control" required></td>
        <td><input type="number" name="items[${rowIndex}][jumlah]" class="form-control" required></td>
        <td><input type="number" name="items[${rowIndex}][harga]" class="form-control" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
    `;

    tbody.appendChild(row);
    rowIndex++;
    hitungTotal();
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
        const jumlah = parseFloat(row.querySelector('input[name*="[jumlah]"]').value) || 0;
        const harga  = parseFloat(row.querySelector('input[name*="[harga]"]').value) || 0;
        total += jumlah * harga;
    });
    document.getElementById('total').value = total;
}

document.getElementById('tbodyInput').addEventListener('input', hitungTotal);
document.getElementById('deposit').addEventListener('input', hitungTotal);
</script>

@endsection