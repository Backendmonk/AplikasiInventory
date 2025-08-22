@extends('Admin.template.main')

@section('judul')
        Dashboard Nota Tambah
@endsection
@section('Judulisi')
    <h2>Dashboard Nota Tambah</h2>
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

 
    @if (session()->has('gagalhapus'))
  <script>

    Swal.fire({
    title: "Gagal",
    text: "Data Sudah Ada Transaksi",
    icon: "error"
    });
</script>
      
  @endif

  
    @if (session()->has('warningTransaksi'))
  <script>

    Swal.fire({
    title: "Warning",
    text: "Selesaikan Transaksi di Inventory Keluar",
    icon: "warning"
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


<!--        

    Table Kategori Barang
-->
{{-- <div class="d-flex">
  <form action="/Admin/sales/Addnota" method="POST" class="mr-2">
    @csrf
    <button type="submit" name="tambah" value="tambah" class="btn btn-primary">
      <i class="fa fa-list" aria-hidden="true"></i> Tambah Nota
    </button>
  </form>

</div> --}}



 
 <br>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Nota</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                           <th>Nama Pesanan</th>
                                            <th>Tanggal Terima</th>
                                           
                                            <th>Status</th>
                                            
                                            <th>Tools</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                       @foreach ($datawo as $data)
                                            <tr>
                                               <td>{{ $data->nama_pesanan }}</td>
                                              <td>{{ $data->diterimaTanggal }}</td>
                                              <td>{{ $data->status }}</td>
                                               <td>
                                                      <div class="dropdown">
                                                          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            Menus
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <form action="/Admin/Sales/NotaItems" method="POST">
                                                              @csrf
                                                              
                                                              <input type="text" hidden name = "idwo" value="{{ $data['id'] }}">

                                                              <li><button class="dropdown-item" type="submit" name ="add" value ="detail">Tambah Nota</button></li>                                                           
                                                          
                                                            </form>
                                                          </ul>
                                                        </div>

                                                                                     
                                                    </td>
                                             
                                            </tr>
                                       @endforeach
                                       
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                  </div>

@endsection