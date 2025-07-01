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



   <form method="POST" action="/Admin/Barang/EditBarang">
    @csrf

 
  <div class="mb-3">

 
    <label for="exampleInputEmail1" class="form-label">Id</label>
    <input type="text"  class="form-control" id="exampleInputEmail1"  name = "id" readonly value = {{$barang['id'] }} aria-describedby="emailHelp">
    
  </div>

    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nama Barang</label>
    <input type="text"  class="form-control" id="exampleInputEmail1" name = "namabarang"  value = {{ $barang['nama_barang']}} aria-describedby="emailHelp">
    
  </div>

<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Kategori Barang</label>
   <select id="Dropdown-data" name="kategori" class="form-control">
    <option value="{{$barang->Kategoribr->id}}">{{$barang->Kategoribr->id}} - {{$barang->Kategoribr->Kategori}}</option>
    @foreach($datakategori as $kategori)
        <option value="{{ $kategori->id }}">{{ $kategori->id }} - {{ $kategori->Kategori }}</option>
    @endforeach
</select>

  </div>


    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Harga Jual</label>
    <input type="text"  class="form-control" id="exampleInputEmail1" name = "hargajual"  value = {{ $barang['HargaJual']}} aria-describedby="emailHelp">
    
  </div>

    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Harga Beli</label>
    <input type="text"  class="form-control" id="exampleInputEmail1" name = "hargamodal" value = {{ $barang['HargaBeli']}} aria-describedby="emailHelp">
    
  </div>
  <input type="text" hidden  class="form-control" id="exampleInputEmail1" name = "hargamodalawal" value = {{ $barang['HargaBeli']}} aria-describedby="emailHelp">



  <button type="submit" name="submit" value = "input" class="btn btn-primary">Edit Kategori</button>

</form>

   

@endsection