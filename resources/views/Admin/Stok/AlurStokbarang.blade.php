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
    text: "Berhasil Stok Opname",
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
                            <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Nama Barang</th>
                                           
                                            <th>Tools</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($databarang as $data)
                                             <tr>
                                                    <td>{{ $data['id'] }}</td>
                                                    <td>{{ $data['nama_barang'] }}</td>
                                                    
                                                

                                                    <td>
                                                      <div class="dropdown">
                                                          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            Menus
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <form action="/Admin/Stok/ToolsalurStok" method="GET">
                                                              @csrf
                                                              
                                                              <input type="text" hidden name = "idbarang" value="{{ $data['id'] }}">

                                                              <li><button class="dropdown-item" type="submit" name ="detail" value ="detail">Detail Stok</button></li>

                                                               <li><button class="dropdown-item" type="submit" name ="opname" value ="opname">Opname Stok</button></li>

                                                           
                                                          
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