@extends('Admin.template.main')

@section('judul')
    Pilih Rentang Tanggal
@endsection

@section('Judulisi')
    <h2 class="text-center mb-4">Pilih Rentang Tanggal</h2>
@endsection

@section('Content1')
<div class="container-fluid d-flex justify-content-center">
    <div class="card shadow p-4" style="width: 450px; border-radius: 15px;">
        <form action="{{ url('Admin/laporan/proses') }}" method="get">
            @csrf
            <div class="mb-3">
                <label class="form-label font-weight-bold">Dari Tanggal</label>
                <input type="date" name="tglawal" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Sampai Tanggal</label>
                <input type="date" name="tglakhir" class="form-control" required>
            </div>

            <input type="text" hidden name="jenis" value="{{ $selected }}"> 
            
            <button type="submit" class="btn btn-primary w-100 mt-3">Lihat Laporan</button>
        </form>
    </div>
</div>

<script>
    // Jika ingin otomatis membawa jenis laporan berdasarkan klik tombol sebelumnya
</script>
@endsection
