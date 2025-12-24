@extends('Kasir.template.main')

@section('judul')
    Saldo Awal Akun
@endsection

@section('tittleCard')
    <h2>Input Saldo Awal: {{ $dataCOA->nama }}</h2>
@endsection

@section('Content1')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Informasi Akun</h3>
                </div>
                <form action="{{ url('Admin/COA/SimpanSaldoAwal') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Kode Akun</label>
                            <input type="text" class="form-control" value="{{ $dataCOA->id }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Akun</label>
                            <input type="text" class="form-control" value="{{ $dataCOA->nama }}" readonly>
                            <input type="hidden" name="akun_id[]" value="{{ $dataCOA->id }}">
                        </div>

                        <div class="form-group">
                            <label>Tanggal Saldo Awal</label>
                            <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group">
                            <label>Nomor Nota / Referensi</label>
                            <input type="text" name="nomor_nota" class="form-control" value="54{{$dataCOA->id}}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Saldo Debit</label>
                                    <input type="number" name="debit[]" class="form-control" placeholder="0" step="any">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Saldo Kredit</label>
                                    <input type="number" name="kredit[]" class="form-control" placeholder="0" step="any">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan_umum" class="form-control" rows="3">Saldo Awal Akun {{ $dataCOA->nama_akun }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan Saldo Awal</button>
                        <a href="{{ url()->previous() }}" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Petunjuk Pengisian</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Pastikan tanggal yang dipilih adalah tanggal awal periode akuntansi.</li>
                        <li>Isi pada kolom <strong>Debit</strong> jika akun ini bertambah di posisi Debit (seperti Kas, Bank, Piutang).</li>
                        <li>Isi pada kolom <strong>Kredit</strong> jika akun ini bertambah di posisi Kredit (seperti Hutang, Modal).</li>
                        <li>Sistem akan otomatis memperbarui saldo di Chart of Account (COA) dan mencatatnya ke dalam Jurnal.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection