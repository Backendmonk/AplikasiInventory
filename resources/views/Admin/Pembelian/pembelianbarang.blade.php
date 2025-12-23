@extends('Admin.template.main')

@section('judul')
       Data Pembelian Barang
@endsection
@section('tittleCard')
    <h2>Data Pembelian Barang</h2>
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


  
    @if (session()->has('gagalhps'))
  <script>

    Swal.fire({
    title: "Gagal",
    text: "Inventory Sudah Ada Transaksi",
    icon: "error"
    });
</script>
      
  @endif

   @if (session()->has('error'))
  <script>

    Swal.fire({
    title: "Gagal",
    text: "Saldo Kas/Bank Tidak Mencukupi",
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
  <form action="/Admin/Pembelian/TambahPembelian" method="GET" class="mr-2">
    @csrf
    <button type="submit" name="tambah" value="tambah" class="btn btn-primary">
      <i class="fa fa-folder-open" aria-hidden="true"></i> Tambah Pembelian Barang
    </button>
  </form>
</div>
  


 
 <br>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pembelian Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Nama Barang</th>
                                            <th>Nomor Nota</th>
                                            <th>Nama Suplier</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Subtotal Harga</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Menus</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($pembelianbarang as $data)
                                             <tr>
                                                    <td>{{ $data['id'] }}</td>
                                                    <td>{{ $data->barangBeli->nama_barang }}</td>
                                                     <td>{{ $data->notaPembelian->id }} <!-- Memanggil Join --></td>
                                                     <td>{{ $data['suplier_nama'] }}</td>
                                                     <td>{{ $data['jumlah_beli'] }}</td>
                                                     <td>{{ $data['harga_beli'] }}</td>
                                                     <td>{{ $data['subtotal_harga_beli'] }}</td>
                                                     <td>{{ $data['created_at'] }}</td>
                                                      <td>{{ $data->notaPembelian->status_nota }}</td>

                                                    <td>
                                                      <div class="dropdown">
                                                          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            Menus
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <form action="/Admin/Pembelian/Detail" method="GET">
                                                              @csrf
                                                              <input type="text" hidden name="idnota" value="{{ $data->notaPembelian->id }}">
                                                              
                                                               @if ($data->notaPembelian->status_nota == 'Hutang' )
                                                              <li><button class="dropdown-item" type="submit" name ="pelunasan" value ="pelunasan">Lunasi</button></li> 
                                                              
                                                              @endif
                                                                  
                                                              
                                                              
                                                                <li><button class="dropdown-item" type="submit" name ="detail" value ="detail">Detail</button></li>
                                                                 <li><button class="dropdown-item" type="submit" name ="history" value ="history">History</button></li> 

                                                            </li>
                                                          
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