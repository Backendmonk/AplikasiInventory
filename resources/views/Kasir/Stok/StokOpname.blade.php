@extends('Kasir.template.main')

@section('judul')
       Opname barang
@endsection
@section('tittleCard')
    <h2>Opname Barang</h2>
@endsection
@section('Content1')





    

<!--        

    Table Kategori Barang
-->



   <form method="POST" action="/Admin/Stok/Opname">
    @csrf

    <input type="text" hidden value  = {{$barang['id']}} name="id">

    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nama Barang</label>
    <input type="text"  class="form-control" id="exampleInputEmail1" name = "namabarang"  value = {{ $barang['nama_barang']}} readonly aria-describedby="emailHelp">
    
  </div>

  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Stok Di Sistem</label>
    <input type="text"  class="form-control" id="exampleInputEmail1" name = "stoksistem"  value = {{ $barang['stok_barang']}}  readonly aria-describedby="emailHelp">
    
  </div>


  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Stok Aktual</label>
    <input type="text"  class="form-control" id="exampleInputEmail1" name = "stokaktual"  aria-describedby="emailHelp">
    
  </div>

  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Pesan</label>
     <textarea name = "pesan" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
    
  </div>



  <button type="submit" name="submit" value = "input" class="btn btn-primary">Opname Stok</button>

</form>

   

@endsection