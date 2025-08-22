@extends('Admin.template.main')

@section('judul')
       Inventory Keluar
@endsection
@section('tittleCard')
    <h2>Inventory Keluar</h2>
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

 
    @if (session()->has('errorinv'))
  <script>

    Swal.fire({
    title: "Gagal",
    text: "Tambahkan Inventory Yang Keluar Terlebih Dahulu",
    icon: "error"
    });
</script>
      
  @endif

  @if(session('msgerror'))
    <div class="alert alert-danger">
        {{ session('msgerror') }}
    </div>
@endif
<div class="container mt-4">

    <form action="/Admin/PO/TambahPO" method="POST">
       
        
        @csrf
        <table class="table table-bordered" id="tableInput">

               <tr>
                    <td><h6>Kode Work Order</h6></td>
                    <td>:</td>
                    <td>{{$datawoget->id  }}</h6></td>
                </tr>
                 <tr>
                    <td><h6>Nama Pemesan</h6></td>
                    <td>:</td>
                    <td>{{ $datawoget->nama_pesanan }}</h6></td>
                </tr>
                 <tr>
                    <td><h6>Pesanan</h6></td>
                    <td>:</td>
                    <td>{{ $datawoget->jenis_pesanan }}</h6></td>
                </tr>
        </table>



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

                        <input type="text" name= "items[0][item]" class="form-control" >

                    </td>
                    <td><input type="number" name="items[0][jumlah]" class="form-control" required></td>
                    <td><input type="number" name="items[0][harga]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-primary mb-3" id="addRow">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>


    <!-- Tom Select JS -->
    <script src="{{asset('/')}}js/tomselect.js"></script>

<script>
    let rowIndex = 1;

    // Simpan isi dropdown ke dalam variabel
    const dropdownOptions = `
      <input type="text" name= "items[0][item]" class="form-control" >

    `;

    // Fungsi untuk inisialisasi TomSelect
    function initTomSelect(el) {
        new TomSelect(el, {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            maxItems: 1
        });
    }

    // Inisialisasi awal
    document.querySelectorAll('.barang-dropdown').forEach(select => initTomSelect(select));

    // Tambah baris baru
    document.getElementById('addRow').addEventListener('click', function () {
        const tbody = document.getElementById('tbodyInput');
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>
                
                 <input type="text" name= "items[${rowIndex}][item]" class="form-control" >


            </td>
            <td><input type="number" name="items[${rowIndex}][jumlah]" class="form-control" required></td>
             <td><input type="number" name="items[${rowIndex}][harga]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
        `;

        tbody.appendChild(row);

        // Inisialisasi TomSelect untuk dropdown baru
        const newDropdown = row.querySelector('.barang-dropdown');
        initTomSelect(newDropdown);

        rowIndex++;
    });

    // Hapus baris
    document.getElementById('tbodyInput').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });
</script>

@endsection