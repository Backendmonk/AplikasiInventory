@extends('Admin.template.main')

@section('judul')
       Kategori barang
@endsection
@section('tittleCard')
    <h2>Kategori Barang</h2>
@endsection
@section('Content1')
@if (session()->has('msgdone'))
  <script>

    Swal.fire({
    title: "Berhasil",
    text: "Berhasil Tambah Kategori",
    icon: "success"
    });
</script>
      
  @endif

 
    @if (session()->has('gagal'))
  <script>

    Swal.fire({
    title: "Gagal",
    text: "Gagal Update",
    icon: "error"
    });
</script>
      
  @endif

<!--        

    Table Kategori Barang
-->
<form action="/Admin/Barang/TambahKategori" method="POST">
  @csrf

  <button type="submit" class = "btn btn-primary">Tambah Kategori</button>
 
</form>
 <br>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data kategori Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Nama Kategori</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($Datakategori as $data)
                                             <tr>
                                                    <td>{{ $data['id'] }}</td>
                                                    <td>{{ $data['Kategori'] }}</td>
                                            
                                            </tr>
                                        @endforeach
                                       
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                  </div>



   

@endsection