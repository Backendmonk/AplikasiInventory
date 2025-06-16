@extends('Admin.template.main')

@section('judul')
        Profile
@endsection
@section('tittleCard')
    <h2>Profile {{ Auth::user()->jenis_akun }}</h2>
@endsection
@section('Content1')
   <form>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nama</label>
    <input type="text" readonly class="form-control" id="exampleInputEmail1" value="{{ Auth::user()->name }}" aria-describedby="emailHelp">
    
  </div>

   <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">User Name</label>
    <input type="text" readonly class="form-control" id="exampleInputEmail1" value="{{ Auth::user()->username }}" aria-describedby="emailHelp">
    
  </div>

  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection