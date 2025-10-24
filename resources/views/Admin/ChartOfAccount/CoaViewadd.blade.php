@extends('Admin.template.main')

@section('judul')
        Tambah barang
@endsection
@section('tittleCard')
    <h2>Tambah Barang</h2>
@endsection
@section('Content1')





    

<!--        

    Table Kategori Barang
-->



   <form method="POST" action="/Admin/Barang/AddBarang">
    @csrf

 
  <div class="mb-3">

    @php
        $randomnumber = rand(1,1000);
    @endphp
    <label for="exampleInputEmail1" class="form-label">Id</label>
    <input type="number" required  class="form-control" id="exampleInputEmail1"  name = "id" value = {{ $randomnumber }} aria-describedby="emailHelp">
  </div>

    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Tipe Akun</label>
   <select id="Dropdown-data" name="kategori" class="form-control">
    <option value="">Pilih Kategori...</option>
    @foreach($tipeakun as $tipe)
        <option value="{{ $tipe->id }}">[{{ $tipe->code }}] {{ $tipe->nama_code }}</option>
    @endforeach
</select>

  </div>


     <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nama Akun</label>
    <input type="number" required   class="form-control" id="exampleInputEmail1" name = "qty" aria-describedby="emailHelp">
    
  </div>

  
     <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Saldo Awal</label>
    <input type="number" required   class="form-control" id="exampleInputEmail1" name = "hargabeli" aria-describedby="emailHelp">
    
  </div>

  
     <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Tanggal Saldo Awal</label>
    <input type="date" required   class="form-control" id="exampleInputEmail1" name = "hargajual" aria-describedby="emailHelp">
    
  </div>


  



  <button type="submit" name="submit" value = "input" class="btn btn-primary">Tambah Barang</button>

</form>



   

@endsection

<!-- Lanjutkan esok -->