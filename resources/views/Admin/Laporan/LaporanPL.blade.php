@extends('Admin.template.main')

@section('judul')
       Data Penjualan
@endsection
@section('tittleCard')
    <h2>Data Penjualan</h2>
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


  @if(session('msgerror'))
    <div class="alert alert-danger">
        {{ session('msgerror') }}
    </div>
@endif


<!--        

    Table Kategori Barang
-->
{{-- <div class="d-flex">
  <form action="/Admin/Barang/TambahBarang" method="POST" class="mr-2">
    @csrf
    <button type="submit" name="tambah" value="tambah" class="btn btn-primary">
      <i class="fa fa-folder-open" aria-hidden="true"></i> Tambah Barang
    </button>
  </form>

  <form action="/Admin/Barang/CekStokBarang" method="POST">
    @csrf
    <button type="submit" name="cekstok" value="cekstok" class="btn btn-info">
      <i class="fa fa-info-circle" aria-hidden="true"></i> Cek Stok Rendah
    </button>
  </form>
</div> --}}



 
 <br>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nomor Nota</th>
                                            <th>Nama Pemesan</th>
                                            <th>Jenis Pesanan</th>
                                            <th>Total Bayar</th>
                                            <th>Dibayarkan</th>
                                            <th>Sisa</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                              
                                    <tbody>
                                        @php
                                            $totalbayar = 0;
                                            $totaldeposit = 0;
                                            $totalsisa = 0;

                                        @endphp
                                        @foreach ($nota as $data)
                                             <tr>
                                                    <td>{{ $data['id'] }}</td>
                                                    <td>{{ $data->ModelwoRS->nama_pesanan }}</td>
                                                    <td>{{ $data->ModelwoRS->jenis_pesanan }}</td>
                                                    <td>Rp.{{ number_format($data['totalbayar'], 0, ',', '.')}}</td>
                                                    <td>RP.{{ number_format($data['deposit'], 0, ',', '.')}}</td>
                                                    <td>Rp.{{ number_format($data['sisapembayaran'], 0, ',', '.')}}</td>
                                                    <td>{{ $data->ModelwoRS->status }}</td>

                                                    
                                                    
                                                     
                                                    
                                            
                                            </tr>

                                            @php
                                                $totalbayar+=$data['totalbayar'];
                                                $totaldeposit+=$data['deposit'];
                                                $totalsisa+=$data['sisapembayaran'];
                                            @endphp
                                        @endforeach
                                       
                                        
                                    </tbody>
                                          <tfoot>
                                        <th colspan="3"></th>
                                            <th >Total  Pembayaran :Rp.{{ number_format($totalbayar, 0, ',', '.') }} </th>
                                            <th>Total Dibayarkan   : Rp.{{ number_format($totaldeposit, 0, ',', '.') }}</th>
                                            <th>Total Sisa   : Rp.{{ number_format($totalsisa, 0, ',', '.') }}</th>
                                            <th></th>

                                    </tfoot>
                                </table>
                            </div>
                        </div>  
                  </div>



   

@endsection