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

  @if (session()->has('msgdoneEdt'))
  <script>

    Swal.fire({
    title: "Berhasil",
    text: "Berhasil Edit Kategori",
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

<!--        

    Table Kategori Barang
-->
<form action="/Admin/Barang/TambahKategori" method="POST">
  @csrf

  <button type="submit" class = "btn btn-primary"><i class="fa  fa-archive" aria-hidden="true"> Tambah Kategori</i></button>
 
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
                                            <th>Tools</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($Datakategori as $data)
                                             <tr>
                                                    <td>{{ $data['id'] }}</td>
                                                    <td>{{ $data['Kategori'] }}</td>
                                                    <td>
                                                      <div class="dropdown">
                                                          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            Menus
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <form action="/Admin/Barang/ToolsEdit" method="GET">
                                                              @csrf
                                                              <input type="text" hidden name = "idKategori" value="{{ $data['id'] }}">
                                                            <li><button class="dropdown-item" type="submit" name ="edit" value = "edit">Edit</button></li>
                                                            <li><button class="dropdown-item" type="submit" name ="hapus" value ="hapus">Hapus</button></li>
                                                          
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