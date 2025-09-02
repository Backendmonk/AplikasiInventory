@extends('Admin.template.main')

@section('judul')
       Tambah Nota
@endsection
@section('tittleCard')
    <h2>Tambah Nota</h2>
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

    <form action="/Admin/Sales/InputNota" method="POST">
       
        
        @csrf
          
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-3" id="printArea">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center no-print">
            <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i> Detail Work Order</h5>
            
        </div>
        <div class="card-body">

          <!-- Data Work Order -->
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


<!-- Rincian Tambahan / Keterangan -->
<h6 class="text-primary"><i class="bi bi-list-check me-2"></i> Rincian Tambahan</h6>
<div class="border rounded bg-light p-3">
    <pre class="mb-0">{{ $datawo->keterangan }}</pre>
</div>
<br>
<h6 class="text-primary"><i class="bi bi-list-check me-2"></i> Invtory Digunakan</h6>
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

        </div>
    </div>
</div>

                 
<br><br>
<h2>Nota</h2>

  
        <table class="table table-bordered" id="tableInput">

            <input type="text" hidden  value="{{ $datawo->id }}" name ="idwo">
             


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

                        <input type="text" name= "items[0][barang]" class="form-control" >

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
                
                 <input type="text" name= "items[${rowIndex}][barang]" class="form-control" >


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