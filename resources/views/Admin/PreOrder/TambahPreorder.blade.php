@extends('Admin.template.main')

@section('judul')
       Tambah Pre Order
@endsection
@section('tittleCard')
    <h2>Tambah Pre Order</h2>
@endsection
@section('Content1')
@if (session()->has('msgdone'))
  <script>

    Swal.fire({
    title: "Berhasil",
    text: "Berhasil Tambah Barang",
    icon: "success"
    });
</script>
      
  @endif

  @if (session()->has('msgdoneEdt'))
  <script>

    Swal.fire({
    title: "Berhasil",
    text: "Berhasil Edit Barang",
    icon: "success"
    });
</script>
      
  @endif

  @if (session()->has('msgdonehps'))
  <script>

    Swal.fire({
    title: "Berhasil",
    text: "Berhasil Dihapus ",
    icon: "success"
    });
</script>
      
  @endif

 
    @if (session()->has('gagal'))
  <script>

    Swal.fire({
    title: "Gagal",
    text: "Kesalahan",
    icon: "error"
    });
</script>
      
  @endif

  @if(session('msgerror'))
    <div class="alert alert-danger">
        {{ session('msgerror') }}
    </div>
@endif

<div class="container">
   <div class="container mt-4">
    <h4>Input Data Transaksi</h4>

    <form action="" method="POST">
        @csrf

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
                    <td><input type="text" name="items[0][nama]" class="form-control" required></td>
                    <td><input type="number" name="items[0][jumlah]" class="form-control" required></td>
                    <td><input type="number" name="items[0][harga]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-primary mb-3" id="addRow"><i class="fa fa-plus" aria-hidden="true"></i></button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>


<script>
    let rowIndex = 1;

    document.getElementById('addRow').addEventListener('click', function () {
        const tbody = document.getElementById('tbodyInput');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="text" name="items[${rowIndex}][nama]" class="form-control" required></td>
            <td><input type="number" name="items[${rowIndex}][jumlah]" class="form-control" required></td>
            <td><input type="number" name="items[${rowIndex}][harga]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
        `;
        tbody.appendChild(row);
        rowIndex++;
    });

    // Event listener untuk tombol hapus
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });
</script>

@endsection