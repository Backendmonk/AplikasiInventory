@extends('Admin.template.main')

@section('judul')
       Data History Pembelian Barang
@endsection
@section('tittleCard')
    <h2>Data History Pembelian Barang</h2>
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
{{-- <div class="d-flex">
  <form action="/Admin/Pembelian/TambahPembelian" method="GET" class="mr-2">
    @csrf
    <button type="submit" name="tambah" value="tambah" class="btn btn-primary">
      <i class="fa fa-folder-open" aria-hidden="true"></i> Tambah Pembelian Barang
    </button>
  </form>
</div>
   --}}


 
 <br>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data History Pembelian Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>id Nota</th>
                                            <th>Nama Metode Bayar</th>
                                            <th>Total Bayar</th>
                                            <th>Dibayarkan</th>
                                            <th>Sisa</th>
                                            <th>Tanggal Pembayaran</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($historypembelian as $data)
                                             <tr>
                                                    <td>{{ $data['id_nota_pembelian'] }}</td>
                                                    <td>{{ $data->metodePayment->nama_metode }}</td>
                                                     <td>{{ $data['totalbayar'] }}</td>
                                                     <td>{{ $data['dibayar'] }}</td>
                                                     <td>{{ $data['sisa'] }}</td>
                                                     <td>{{ $data['created_at'] }}</td>
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