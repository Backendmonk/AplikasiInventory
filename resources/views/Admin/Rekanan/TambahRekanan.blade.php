@extends('Admin.template.main')

@section('judul')
        Tambah Rekanan
@endsection
@section('tittleCard')
    <h2>Tambah Rekanan</h2>
@endsection
@section('Content1')





    

<!--        

    Table Kategori Rekanan
-->



   <form method="POST" action="/Admin/Rekanan/Addrekanan">
    @csrf

    

 
  <div class="mb-3">

    @php
        $randomnumber = rand(1,999999);
    @endphp
    <label for="exampleInputEmail1" class="form-label">Id</label>
    <input type="number" required  class="form-control" id="exampleInputEmail1"  name = "id" value = {{ $randomnumber }} aria-describedby="emailHelp">
  </div>

   <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nama Rekanan</label>
    <input type="text" required  class="form-control" id="exampleInputEmail1" name = "rekanan" aria-describedby="emailHelp">
    
  </div>

  
   <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Alamat</label>
    <input type="text" required  class="form-control" id="exampleInputEmail1" name = "alamat" aria-describedby="emailHelp">
    
  </div>


 

 



  <button type="submit" name="submit" value = "input" class="btn btn-primary">Tambah Rekanan</button>

</form>



   

@endsection