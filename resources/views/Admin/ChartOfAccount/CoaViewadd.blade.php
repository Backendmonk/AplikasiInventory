@extends('Admin.template.main')

@section('judul')
        Tambah Akun 
@endsection
@section('tittleCard')
    <h2>Tambah Akun </h2>
@endsection
@section('Content1')





    

<!--        

    Table Kategori Barang
-->



   <form method="POST" action="/Admin/COA/CoaAdd">
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
   <select id="Dropdown-data" name="tipe" class="form-control">
    <option value="">Pilih tipe...</option>
    @foreach($tipeakun as $tipe)
        <option value="{{ $tipe->id }}">[{{ $tipe->code }}] {{ $tipe->nama_code }}</option>
    @endforeach
</select>

  </div>

  

     <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Kode Akun</label>
    <input type="text" required autocomplete="false"   class="form-control" id="exampleInputEmail1" name = "kode_akun" aria-describedby="emailHelp">
    
  </div>


     <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nama Akun</label>
    <input type="text" required autocomplete="false"   class="form-control" id="exampleInputEmail1" name = "nama_akun" aria-describedby="emailHelp">
    
  </div>

  
     <div class="mb-3">
    <label for="exampleI nputEmail1" class="form-label">Saldo Awal</label>
    <input type="number" value = "0" required autocomplete="false"  class="form-control" id="exampleInputEmail1" name = "saldoawal" aria-describedby="emailHelp">
    
  </div>

  
     <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Tanggal Saldo Awal</label>
    <input type="date" required  autocomplete="false" class="form-control" id="exampleInputEmail1" name = "tgl" aria-describedby="emailHelp">
    
  </div>


  



  <button type="submit" name="submit" value = "input" class="btn btn-primary">Tambah COA</button>

</form>



   

@endsection

<!-- Lanjutkan esok -->