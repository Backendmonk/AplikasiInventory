@extends('Admin.template.main')

@section('judul')
    Pilih Laporan
@endsection

@section('Judulisi')
    <h2 class="text-center mb-4">Pilih Laporan</h2>
@endsection

@section('Content1')
<div class="container-fluid">
    <div class="row justify-content-center">
        <!-- Card Jurnal -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2 report-card" onclick="window.location.href='{{ url('Admin/laporan/jurnal') }}'">
                <div class="card-body text-center">
                    <i class="fas fa-book fa-3x mb-3"></i>
                    <h5 class="font-weight-bold">Jurnal</h5>
                    <p class="text-muted">Laporan transaksi harian</p>
                </div>
            </div>
        </div>

        <!-- Card Laba Rugi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2 report-card" onclick="window.location.href='{{ url('Admin/laporan/labarugi') }}'">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-3x mb-3"></i>
                    <h5 class="font-weight-bold">Laba Rugi</h5>
                    <p class="text-muted">Perhitungan profit bisnis</p>
                </div>
            </div>
        </div>

        <!-- Card Neraca -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2 report-card" onclick="window.location.href='{{ url('Admin/laporan/neraca') }}'">
                <div class="card-body text-center">
                    <i class="fas fa-balance-scale fa-3x mb-3"></i>
                    <h5 class="font-weight-bold">Neraca</h5>
                    <p class="text-muted">Posisi aset, kewajiban & modal</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .report-card {
        cursor: pointer;
        border-radius: 15px;
        transition: 0.3s;
    }
    .report-card:hover {
        transform: translateY(-7px);
        box-shadow: 0px 10px 20px rgba(0,0,0,0.2);
        background: #f8f9fc;
    }
</style>
@endsection