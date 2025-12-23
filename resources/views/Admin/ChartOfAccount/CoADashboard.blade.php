@extends('Admin.template.main')

@section('judul')
       Data COA
@endsection
@section('tittleCard')
    <h2>Data COA</h2>
@endsection
@section('Content1')
@if (session()->has('msgdone'))
  <script>

    Swal.fire({
    title: "Berhasil",
    text: "Berhasil Tambah COA",
    icon: "success"
    });
</script>
      
  @endif

  @if (session()->has('msgdoneEdt'))
  <script>

    Swal.fire({
    title: "Berhasil",
    text: "Berhasil Edit COA",
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

  
    @if (session()->has('gagalCOA'))
  <script>

    Swal.fire({
    title: "Gagal",
    text: "Saldo Awal Tidak Ada, Kesalahan Silahkan Coba Lagi",
    icon: "warning"
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

    Table Kategori COA
-->
<div class="d-flex">
  <form action="/Admin/coa/TambahCOA" method="POST" class="mr-2">
    @csrf
    <button type="submit" name="tambah" value="tambah" class="btn btn-primary">
      <i class="fa fa-folder-open" aria-hidden="true"></i> Tambah Akun
    </button>
  </form>

  {{-- <form action="/Admin/Barang/CekStokBarang" method="POST">
    @csrf
    <button type="submit" name="cekstok" value="cekstok" class="btn btn-info">
      <i class="fa fa-info-circle" aria-hidden="true"></i> Cek Stok Rendah
    </button>
  </form> --}}
</div>



 
 <br>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Chart Of Account</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama Akun</th>
                                            <th>Jenis Akun</th>
                                            <th>Saldo</th>
                                            <th>Keterangan Akun</th>
                                            {{-- <th>Tools</th> --}}
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($dataCOA as $data)
                                             <tr>
                                                    <td>{{ $data['kode'] }}</td>
                                                    <td>{{ $data['nama'] }}</td>
                                                    
                                                     <td>{{ $data->tipeakun->nama_code }} <!-- Memanggil Join --></td>
                                                     <td>Rp {{ number_format($data['saldo'], 0, ',', '.') }}</td>

                                                     <td>{{ $data['keterangan'] }}</td>


                                                   
                                                      {{-- 
                                                       <td>
                                                      <div class="dropdown">
                                                          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            Menus
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <form action="/Admin/COA/DetailCOA" method="POST">
                                                              @csrf
                                                              
                                                              <input type="text" hidden name = "idbarang" value="{{ $data['id'] }}">

                                                              {{-- <li><button class="dropdown-item" type="submit" name ="detail" value ="detail">Detail</button></li> 

                                                      
                                                          
                                                            </form>
                                                          </ul>
                                                        </div>
                                                        
                                                        </td>
                                                        
                                                        --}}

                                                                                     
                                                    
                                            
                                            </tr>
                                        @endforeach
                                       
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                  </div>



   

@endsection