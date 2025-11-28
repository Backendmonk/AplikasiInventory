@extends('Admin.template.main')

@section('judul')
        Tambah Payment
@endsection
@section('tittleCard')
    <h2>Tambah Payment</h2>
@endsection
@section('Content1')





    

<!--        

    Table Kategori Payment
-->



   <form method="POST" action="/Admin/Payment/PaymentAdd">
    @csrf

 

   <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Metode Pembayaran</label>
    <input type="text" required  class="form-control" id="exampleInputEmail1" name = "namapayment" aria-describedby="emailHelp">
    
  </div>

  


   <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Kategori Payment</label>
   <select id="Dropdown-data" name="kategoripayemnt" class="form-control">
    <option value="">Pilih Kategori...</option>
    @foreach($datacoa as $data)
        <option value="{{ $data->id }}">{{ $data->id }} - {{ $data->nama }}</option>
    @endforeach
</select>

  </div>



  



  <button type="submit" name="submit" value = "input" class="btn btn-primary">Tambah Barang</button>

</form>



   

@endsection