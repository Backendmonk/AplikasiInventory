@extends('Admin.template.main')

@section('judul')
Pembelian Barang
@endsection

@section('Content1')
<div class="container mt-4">

<form action="/Admin/WO/InvKeluar" method="POST">
@csrf

{{-- ================= HEADER ================= --}}
<div class="row mb-3">
    <div class="col-md-4">
        <label>Tanggal Pembelian</label>
        <input type="date" name="tanggal_pembelian" class="form-control" required>
    </div>

    <div class="col-md-8">
        <label>Nama Supplier</label>
        <input type="text" name="supplier_nama" class="form-control" required>
    </div>
</div>

{{-- ================= TABLE ================= --}}
<table class="table table-bordered">
<thead>
<tr>
    <th>Nama Barang</th>
    <th width="120">Jumlah</th>
    <th width="150">Harga Beli</th>
    <th width="150">Subtotal</th>
    <th width="80">Aksi</th>
</tr>
</thead>

<tbody id="tbodyInput">
<tr>
    <td>
        <select name="items[0][barang]" class="form-control barang-dropdown">
            <option value="">Pilih Barang...</option>
            @foreach($databarang as $barang)
                
                    <option value="{{ $barang->id }}" data-harga="{{ $barang->HargaBeli }}">
                        {{ $barang->nama_barang }}
                    </option>
             
            @endforeach
        </select>
    </td>

    <td>
        <input type="number" name="items[0][jumlah]" class="form-control jumlah" min="1">
    </td>

    <td>
        <input type="number" name="items[0][harga_beli]" class="form-control harga" readonly>
    </td>

    <td>
        <input type="number" name="items[0][subtotal]" class="form-control subtotal" readonly>
    </td>

    <td>
        <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
    </td>
</tr>
</tbody>
</table>

<button type="button" class="btn btn-primary" id="addRow">+ Tambah Barang</button>

<hr>

{{-- ================= PEMBAYARAN ================= --}}
<div class="row">
    <div class="col-md-6">
        <label>Metode Bayar</label>
        <select name="metodebayar" class="form-control" required>
            <option value="">Pilih Metode Pembayaran</option>
            @foreach($datametodebayar as $data)
                <option value="{{ $data->id }}">
                    {{ $data->id }} - {{ $data->nama_metode }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <label>Deposit</label>
        <input type="number" class="form-control" name="deposit" id="deposit" value="0">
    </div>

    <div class="col-md-6">
        <label>Total Harga</label>
        <input type="number" class="form-control" id="total" name="total" readonly>
    </div>
</div>

<br>
<button type="submit" class="btn btn-success">Simpan</button>

</form>
</div>

{{-- ================= OPTION TEMPLATE (PENTING) ================= --}}
<script>
const dropdownOptions = `
<option value="">Pilih Barang...</option>
@foreach($databarang as $barang)
   
        <option value="{{ $barang->id }}" data-harga="{{ $barang->HargaBeli }}">
            {{ $barang->nama_barang }}
        </option>
        
@endforeach
`;
</script>

{{-- ================= JS LOGIC ================= --}}
<script>
let rowIndex = 1;

function hitungSubtotal(row){
    let jumlah = parseInt(row.querySelector('.jumlah').value) || 0;
    let harga  = parseInt(row.querySelector('.harga').value) || 0;
    row.querySelector('.subtotal').value = jumlah * harga;
    hitungTotal();
}

function hitungTotal(){
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(el => {
        total += parseInt(el.value) || 0;
    });
    document.getElementById('total').value = total;
}

// pilih barang → isi harga
document.addEventListener('change', function(e){
    if(e.target.classList.contains('barang-dropdown')){
        const opt = e.target.options[e.target.selectedIndex];
        const harga = opt.dataset.harga || 0;
        const row = e.target.closest('tr');
        row.querySelector('.harga').value = harga;
        hitungSubtotal(row);
    }
});

// input jumlah
document.addEventListener('input', function(e){
    if(e.target.classList.contains('jumlah')){
        hitungSubtotal(e.target.closest('tr'));
    }
});

// tambah baris (FIX TOTAL)
document.getElementById('addRow').addEventListener('click', function(){
    const tbody = document.getElementById('tbodyInput');

    const row = document.createElement('tr');
    row.innerHTML = `
        <td>
            <select name="items[${rowIndex}][barang]" class="form-control barang-dropdown">
                ${dropdownOptions}
            </select>
        </td>
        <td>
            <input type="number" name="items[${rowIndex}][jumlah]" class="form-control jumlah" min="1">
        </td>
        <td>
            <input type="number" name="items[${rowIndex}][harga_beli]" class="form-control harga" readonly>
        </td>
        <td>
            <input type="number" name="items[${rowIndex}][subtotal]" class="form-control subtotal" readonly>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
        </td>
    `;

    tbody.appendChild(row);
    rowIndex++;
});

// hapus baris
document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-row')){
        e.target.closest('tr').remove();
        hitungTotal();
    }
});
</script>
@endsection
