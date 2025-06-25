@extends('Admin.template.main')

@section('judul')
       Data barang
@endsection
@section('tittleCard')
    <h2>Data Barang</h2>
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

<!--        

    Table Kategori Barang
-->
<form action="/Admin/Barang/DashboardBarang" method="POST">
  @csrf
    <!-- Kerjakan ini nanti -->
  <button type="submit" name = "tambah" value ="tambah" class = "btn btn-primary"><i class="fa fa-folder-open" aria-hidden="true"> Tambah Barang</i></button>
  <button type="submit" name = "cekstok" value = "cekstok" class = "btn btn-info"><i class="fa fa-info-circle" aria-hidden="true"> Cek Stok Rendah</i></button>
 
</form>
 <br>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Nama Barang</th>
                                            <th>Kategori</th>
                                            <th>Stok</th>
                                            <th>Tools</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        {{-- @foreach ($Datakategori as $data)
                                             <tr>
                                                    <td>{{ $data['id'] }}</td>
                                                    <td>{{ $data['Kategori'] }}</td>
                                                    <td>
                                                      <div class="dropdown">
                                                          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            Menus
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <form action="/Admin/Barang/ToolsEdit" method="POST">
                                                              @csrf
                                                              <input type="text" hidden name = "idKategori" value="{{ $data['id'] }}">
                                                            <li><button class="dropdown-item" type="submit" name ="edit" value = "edit">Edit</button></li>
                                                            <li><button class="dropdown-item" type="submit" name ="hapus" value ="hapus">Hapus</button></li>
                                                          
                                                            </form>
                                                          </ul>
                                                        </div>

                                                                                     
                                                    </td>
                                            
                                            </tr>
                                        @endforeach --}}
                                       
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                  </div>



   

@endsection