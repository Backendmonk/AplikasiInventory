@extends('Admin.template.main')

@section('judul')
    Jurnal Manual
@endsection

@section('tittleCard')
    <h2>Input Jurnal Manual</h2>
@endsection

@section('Content1')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Entry Transaksi</h5>
        </div>
        <div class="card-body">
            <form id="jurnalForm">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="font-weight-bold">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="font-weight-bold">No. Referensi / Nota</label>
                        <input type="text" name="nomor_nota" class="form-control" placeholder="Contoh: BM-001">
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Keterangan Umum</label>
                        <input type="text" name="keterangan_umum" class="form-control" placeholder="Deskripsi transaksi...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="tableJurnal">
                        <thead class="bg-light">
                            <tr class="text-center">
                                <th width="45%">Akun</th>
                                <th width="22%">Debet</th>
                                <th width="22%">Kredit</th>
                                <th width="11%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="rowContainer">
                            <tr class="jurnal-row">
                                <td>
                                    <select name="akun_id[]" class="form-control select-akun">
                                        <option value="">-- Pilih Akun --</option>
                                        {{-- Loop data akun di sini nanti --}}
                                    </select>
                                </td>
                                <td><input type="number" name="debit[]" class="form-control input-debit" value="0"></td>
                                <td><input type="number" name="kredit[]" class="form-control input-kredit" value="0"></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr class="jurnal-row">
                                <td>
                                    <select name="akun_id[]" class="form-control select-akun">
                                        <option value="">-- Pilih Akun --</option>
                                        {{-- Loop data akun di sini nanti --}}
                                    </select>
                                </td>
                                <td><input type="number" name="debit[]" class="form-control input-debit" value="0"></td>
                                <td><input type="number" name="kredit[]" class="form-control input-kredit" value="0"></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-light font-weight-bold">
                            <tr>
                                <td class="text-right">TOTAL</td>
                                <td><input type="text" id="totalDebit" class="form-control-plaintext text-success font-weight-bold" value="Rp 0" readonly></td>
                                <td><input type="text" id="totalKredit" class="form-control-plaintext text-danger font-weight-bold" value="Rp 0" readonly></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-outline-primary" id="addMoreRow">
                            <i class="fas fa-plus"></i> Tambah Baris
                        </button>
                    </div>
                    <div class="col-md-6 text-right">
                        <div id="balanceStatus" class="d-inline-block mr-3 p-2 rounded border border-warning text-warning font-weight-bold">
                            STATUS: TIDAK BALANCE
                        </div>
                        <button type="submit" class="btn btn-success px-5" id="btnSimpan" disabled>SIMPAN JURNAL</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    
    // Fungsi Hitung Balance
    function checkBalance() {
        let totalD = 0;
        let totalK = 0;

        $('.input-debit').each(function() {
            totalD += parseFloat($(this).val()) || 0;
        });

        $('.input-kredit').each(function() {
            totalK += parseFloat($(this).val()) || 0;
        });

        // Format Rupiah sederhana
        $('#totalDebit').val('Rp ' + totalD.toLocaleString('id-ID'));
        $('#totalKredit').val('Rp ' + totalK.toLocaleString('id-ID'));

        // Logika Tombol Simpan & Status
        const diff = Math.abs(totalD - totalK);
        if (totalD > 0 && totalK > 0 && diff < 0.01) {
            $('#balanceStatus').text('STATUS: BALANCE').removeClass('border-warning text-warning').addClass('border-success text-success');
            $('#btnSimpan').prop('disabled', false);
        } else {
            $('#balanceStatus').text('STATUS: TIDAK BALANCE').removeClass('border-success text-success').addClass('border-warning text-warning');
            $('#btnSimpan').prop('disabled', true);
        }
    }

    // Tambah Baris Baru
    $('#addMoreRow').click(function() {
        const newRow = `
            <tr class="jurnal-row">
                <td>
                    <select name="akun_id[]" class="form-control select-akun">
                        <option value="">-- Pilih Akun --</option>
                    </select>
                </td>
                <td><input type="number" name="debit[]" class="form-control input-debit" value="0"></td>
                <td><input type="number" name="kredit[]" class="form-control input-kredit" value="0"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;
        $('#rowContainer').append(newRow);
    });

    // Hapus Baris
    $(document).on('click', '.remove-row', function() {
        if ($('.jurnal-row').length > 2) {
            $(this).closest('tr').remove();
            checkBalance();
        } else {
            alert('Minimal harus ada 2 baris (Debet & Kredit)');
        }
    });

    // Event saat input angka berubah
    $(document).on('input', '.input-debit, .input-kredit', function() {
        // Simple UX: Kalau Debet diisi, Kredit baris yang sama otomatis jadi 0 (dan sebaliknya)
        let row = $(this).closest('tr');
        if($(this).hasClass('input-debit') && $(this).val() > 0) {
            row.find('.input-kredit').val(0);
        } else if($(this).hasClass('input-kredit') && $(this).val() > 0) {
            row.find('.input-debit').val(0);
        }
        checkBalance();
    });
});
</script>
@endsection