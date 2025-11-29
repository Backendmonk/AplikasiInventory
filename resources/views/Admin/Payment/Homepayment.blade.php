@extends('Admin.template.main')

@section('judul')
       Data Metode Pembayaran
@endsection
@section('tittleCard')
    <h2>Data Metode Pembayaran</h2>
@endsection
@section('Content1')
@if (session()->has('msgdone'))
  <script>

    Swal.fire({
    title: "Berhasil",
    text: "Berhasil Tambah Metode Pembayaran",
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


  
    @if (session()->has('gagalhps'))
  <script>

    Swal.fire({
    title: "Gagal",
    text: "Inventory Sudah Ada Transaksi",
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
<div class="d-flex">
  <form action="/Admin/Payment/TambahPayment" method="POST" class="mr-2">
    @csrf
    <button type="submit" name="tambah" value="tambah" class="btn btn-primary">
      <i class="fa fa-credit-card" aria-hidden="true"></i> Tambah Metode Pembayaran
    </button>
  </form>
</div>



 
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
                                            
                                            <th>Nama Payment</th>
                                            <th>Kategori</th>
                                        
                                            {{-- <th>Tools</th> --}}
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($datapayment as $data)
                                             <tr>
                                                    <td>{{ $data['nama_metode'] }}</td>
                                                                                                   
                                                     <td>{{ $data->metodebayar->nama }} <!-- Memanggil Join --></td>
                        

                                                    {{-- <td>
                                                      <div class="dropdown">
                                                          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            Menus
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <form action="/Admin/Barang/ToolsEditBarang" method="POST">
                                                              @csrf
                                                              
                                                              <input type="text" hidden name = "idbarang" value="{{ $data['id'] }}">

                                                              <li><button class="dropdown-item" type="submit" name ="detail" value ="detail">Detail</button></li>

                                                            <li><button class="dropdown-item" type="submit" name ="edit" value = "edit">Edit</button></li>
                                                            <li><button class="dropdown-item" type="submit" name ="hapus" value ="hapus">Hapus</button></li>
                                                             <li><button class="dropdown-item" type="submit" name ="sembunyi" value ="sembunyi">Sembunyikan</button></li>
                                                          
                                                            </form>
                                                          </ul>
                                                        </div>

                                                                                     
                                                    </td> --}}
                                            
                                            </tr>
                                        @endforeach
                                       
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                  </div>



   

@endsection