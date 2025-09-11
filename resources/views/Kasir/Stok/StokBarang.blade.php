@extends('Kasir.template.main')

@section('judul')
       Data Stok
@endsection
@section('tittleCard')
    <h2>Data Stok</h2>
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




 
 <br>
 
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Stok</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Nama Barang</th>
                                            <th>Stok</th>
                                            <th>Pertanggal</th>
                                            
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($datastok as $data)
                                             <tr>
                                                    <td>{{ $data['id'] }}</td>
                                                                                                  
                                                     <td>{{ $data->barangist->nama_barang}} <!-- Memanggil Join --></td>
                                                     <td>{{ $data['stok'] }}</td>
                                                       <td>{{ $data['pertanggal'] }}</td>

                                                   
                                            
                                            </tr>
                                        @endforeach
                                       
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                  </div>



   

@endsection