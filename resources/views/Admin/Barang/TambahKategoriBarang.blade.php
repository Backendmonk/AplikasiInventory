@extends('Admin.template.main')

@section('judul')
       Kategori barang
@endsection
@section('tittleCard')
    <h2>Kategori Barang</h2>
@endsection
@section('Content1')





    

<!--        

    Table Kategori Barang
-->



   <form method="POST" action="/Admin/Barang/AddKatagori">
    @csrf

 
  <div class="mb-3">

    @php
        $randomnumber = rand(1,999999);
    @endphp
    <label for="exampleInputEmail1" class="form-label">Id</label>
    <input type="text"  class="form-control" id="exampleInputEmail1"  name = "id" readonly value = {{ $randomnumber }} aria-describedby="emailHelp">
    
  </div>

   <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Kategori Barang</label>
    <input type="text"  class="form-control" id="exampleInputEmail1" name = "kategori" aria-describedby="emailHelp">
    
  </div>



  <button type="submit" name="submit" value = "input" class="btn btn-primary">Tambah Kategori</button>

</form>

   

@endsection