@extends('Admin.template.main')

@section('judul')
        Data Nota
@endsection
@section('Judulisi')
    <h2>Data Nota</h2>
@endsection
@section('Content1')
   
@if (session()->has('msgdone'))
  <script>

    Swal.fire({
    title: "Berhasil",
    text: "Berhasil Tambah Nota",
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




  @if(session('msgerror'))
    <div class="alert alert-danger">
        {{ session('msgerror') }}
    </div>
@endif


<!--        

    Table Kategori Barang
-->



 
 <br>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Nota</h6>
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
                                                            <form action="/Admin/Sales/notaview" method="get">
                                                              @csrf
                                                              
                                                              <input type="text" hidden name = "idwo" value="{{ $data['id'] }}">

                                                              @php
                                                                  if ($data->status =="Piutang") {
                                                                    # code...
                                                                    echo'  <li><button class="dropdown-item" type="submit" name ="pelunasan" value ="pelunasan">Lunasi</button></li>';
                                                                  }else{

                                                                  }
                                                              @endphp

                                                              <li><button class="dropdown-item" type="submit" name ="detail" value="detail">Detail / Cetak</button></li>
                                                              <li><button class="dropdown-item" type="submit" name ="history" value="detail">History Transaksi</button></li>

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