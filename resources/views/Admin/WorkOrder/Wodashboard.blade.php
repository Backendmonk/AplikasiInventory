@extends('Admin.template.main')

@section('judul')
        Dashboard
@endsection
@section('Judulisi')
    <h2>Dashboard</h2>
@endsection
@section('Content1')
    <div class="container mt-4">
    <form>
        <!-- Tanggal -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="diterima_tgl" class="form-label">Diterima Tgl.</label>
                <input type="date" class="form-control" id="diterima_tgl" name="diterima_tgl">
            </div>
            <div class="col-md-3">
                <label for="selesai_tgl" class="form-label">Selesai Tgl.</label>
                <input type="date" class="form-control" id="selesai_tgl" name="selesai_tgl">
            </div>
        </div>

        <!-- Data Pesanan -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Nama Pemesan</label>
                <input type="text" class="form-control" name="nama_pemesan">
            </div>
            <div class="col-md-4">
                <label class="form-label">Jenis Pesanan</label>
                <input type="text" class="form-control" name="jenis_pesanan">
            </div>
            <div class="col-md-4">
                <label class="form-label">Jumlah Pesanan</label>
                <input type="number" class="form-control" name="jumlah_pesanan">
            </div>
        </div>

        <!-- Spesifikasi -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Jenis Kertas</label>
                <input type="text" class="form-control" name="jenis_kertas">
            </div>
            <div class="col-md-4">
                <label class="form-label">Warna Tinta</label>
                <input type="text" class="form-control" name="warna_tinta">
            </div>
            <div class="col-md-4">
                <label class="form-label">Ukuran Cetak</label>
                <input type="text" class="form-control" name="ukuran_cetak">
            </div>
        </div>

        <!-- Ukuran & Rangka -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Ukuran Jadi</label>
                <input type="text" class="form-control" name="ukuran_jadi">
            </div>
            <div class="col-md-4">
                <label class="form-label">Rangka/Susunan</label>
                <input type="text" class="form-control" name="rangka_susunan">
            </div>
        </div>

        <!-- Reproduksi -->
        <div class="mb-3">
            <label class="form-label">Reproduksi</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="reproduksi[]" value="Cetak Offset">
                <label class="form-check-label">Cetak Offset</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="reproduksi[]" value="Porporasi">
                <label class="form-check-label">Porporasi</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="reproduksi[]" value="Cetak Perfor">
                <label class="form-check-label">Cetak Perfor</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="reproduksi[]" value="Folio">
                <label class="form-check-label">Folio</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="reproduksi[]" value="P52">
                <label class="form-check-label">P 52</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="reproduksi[]" value="P58">
                <label class="form-check-label">P 58</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="reproduksi[]" value="P72">
                <label class="form-check-label">P 72</label>
            </div>
        </div>

        <!-- Lain-lain -->
        <div class="mb-3">
            <label class="form-label">Lainnya</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="lainnya[]" value="Sablon">
                <label class="form-check-label">Sablon</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="lainnya[]" value="Lem">
                <label class="form-check-label">Lem (Atas/Samping)</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="lainnya[]" value="Cetak Ulang">
                <label class="form-check-label">Cetak Ulang</label>
            </div>
        </div>

        <!-- Sistem Jilid -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Sistem Jilid</label>
                <input type="text" class="form-control" name="sistem_jilid">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status Order</label>
                <input type="text" class="form-control" name="status_order">
            </div>
            <div class="col-md-4">
                <label class="form-label">Plat</label>
                <input type="text" class="form-control" name="plat">
            </div>
        </div>

        <!-- Nomorator & Tinta -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Nomorator Start</label>
                <input type="text" class="form-control" name="nomorator_start">
            </div>
            <div class="col-md-4">
                <label class="form-label">Warna Tinta</label>
                <input type="text" class="form-control" name="warna_tinta2">
            </div>
            <div class="col-md-4">
                <label class="form-label">Isi Perbuku</label>
                <input type="text" class="form-control" name="isi_perbuku">
            </div>
        </div>

        <!-- Harga -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Harga</label>
                <input type="text" class="form-control" name="harga">
            </div>
        </div>

        <!-- Tombol -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection