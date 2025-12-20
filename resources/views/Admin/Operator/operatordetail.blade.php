@extends('Admin.template.main')

@section('judul')
       Data WO Operator
@endsection
@section('tittleCard')
    <h2>Data WO Operator</h2>
@endsection
@section('Content1')
@if (session()->has('msgdone'))
  <script>

    Swal.fire({
    title: "Berhasil",
    text: "Berhasil Tambah Operator",
    icon: "success"
    });
</script>
      
  @endif

  @if (session()->has('msgdoneEdt'))
  <script>

    Swal.fire({
    title: "Berhasil",
    text: "Berhasil Edit Operator",
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





 
 <br>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data WO Operator</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                           
                                            <th>Nama Operator</th>
                                            <th>Id WO</th>
                                            <th>Mesin</th>
                                            <th>Status WO</th>
                                            <th>Harga</th>
                                            </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($woget as $data)
                                             <tr>
                                                    

                                                   <td>
                                                        @if ($data->wocetak && $data->wocetak->id == $idoperator)
                                                            {{ $data->wocetak->nama_operator }}
                                                        @elseif ($data->wopotong && $data->wopotong->id == $idoperator)
                                                            {{ $data->wopotong->nama_operator }}
                                                        @elseif ($data->woproduksi && $data->woproduksi->id == $idoperator)
                                                            {{ $data->woproduksi->nama_operator }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    
                                                    
                                                    
                                                    <td>{{ $data['id'] }}</td>
                                                    <td>{{ $data->plat }}</td>
                                                    <td>{{ $data->status }}</td>                                                   
                                                    <td>Rp.{{ number_format($data->harga, 0, ',', '.') }}</td>
                                            
                                            </tr>
                                        @endforeach
                                       
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                  </div>



   

@endsection