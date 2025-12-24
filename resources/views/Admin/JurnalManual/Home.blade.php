@extends('Admin.template.main')

@section('judul')
    Jurnal Manual
@endsection

{{-- Bagian Notifikasi SweetAlert2 --}}
@if (session()->has('msgdone'))
<script>
    Swal.fire({
        title: "Berhasil",
        text: "{{ session('msgdone') }}",
        icon: "success"
    });
</script>
@endif

@if (session()->has('error'))
<script>
    Swal.fire({
        title: "Gagal",
        text: "{{ session('error') }}",
        icon: "error"
    });
</script>
@endif

{{-- 1. Tambahkan CSS Tom Select dari folder lokal --}}
@push('css')
<link href="{{ asset('css/tom-select.bootstrap4.min.css') }}" rel="stylesheet" />
<style>
    /* Penyesuaian agar Tom Select terlihat menyatu dengan Bootstrap */
    .ts-control {
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
        padding: 0.375rem 0.75rem !important;
    }
    .ts-wrapper.single .ts-control {
        height: calc(1.5em + 0.75rem + 2px) !important;
    }
    /* Agar teks keterangan tidak terlalu dominan */
    .option-desc {
        font-size: 0.85em;
        color: #6c757d;
        margin-left: 5px;
    }
</style>
@endpush

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
            <form id="jurnalForm" method="POST" action="{{ url('Admin/JurnalManual/Simpan') }}">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="font-weight-bold">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="font-weight-bold">No. Referensi / Nota</label>
                        <input type="text" name="nomor_nota" class="form-control" placeholder="Contoh: BM-001" required>
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
                                <th width="45%">Akun (Cari Akun...)</th>
                                <th width="22%">Debet</th>
                                <th width="22%">Kredit</th>
                                <th width="11%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="rowContainer">
                            {{-- Baris di-generate via JS --}}
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

{{-- 2. Load JS Lokal sesuai folder public/js/ --}}
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/tomselect.js') }}"></script>

<script>
$(document).ready(function() {
    // Ambil data COA dari Laravel
    const dataAkun = @json($COA);

    // 3. Fungsi Inisialisasi Tom Select
    function initTomSelect(element) {
        new TomSelect(element, {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: "-- Pilih atau Cari Akun --",
            allowEmptyOption: true,
        });
    }

    // 4. Fungsi Tambah Baris (Menampilkan Nama + Keterangan)
    function addNewRow() {
        let options = '<option value="">-- Pilih Akun --</option>';
        dataAkun.forEach(function(item) {
            // Menambahkan keterangan di samping nama akun
            let ket = item.keterangan ? ` - ${item.keterangan}` : '';
            options += `<option value="${item.id}">${item.nama}${ket}</option>`;
        });

        const newRow = $(`
            <tr class="jurnal-row">
                <td>
                    <select name="akun_id[]" class="select-akun" required>
                        ${options}
                    </select>
                </td>
                <td><input type="number" name="debit[]" class="form-control input-debit" value="0" step="any"></td>
                <td><input type="number" name="kredit[]" class="form-control input-kredit" value="0" step="any"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`);
        
        $('#rowContainer').append(newRow);
        
        // Inisialisasi Tom Select untuk elemen baru
        const selectElement = newRow.find('.select-akun')[0];
        initTomSelect(selectElement);
    }

    // Load 2 baris awal saat halaman dibuka
    addNewRow();
    addNewRow();

    // Fungsi Hitung Balance & Format Rupiah
    function checkBalance() {
        let totalD = 0;
        let totalK = 0;

        $('.input-debit').each(function() {
            totalD += parseFloat($(this).val()) || 0;
        });

        $('.input-kredit').each(function() {
            totalK += parseFloat($(this).val()) || 0;
        });

        $('#totalDebit').val('Rp ' + totalD.toLocaleString('id-ID'));
        $('#totalKredit').val('Rp ' + totalK.toLocaleString('id-ID'));

        const diff = Math.abs(totalD - totalK);
        // Validasi: Harus lebih dari 0 dan selisihnya nol
        if (totalD > 0 && totalK > 0 && diff < 0.01) {
            $('#balanceStatus').text('STATUS: BALANCE').removeClass('border-warning text-warning').addClass('border-success text-success');
            $('#btnSimpan').prop('disabled', false);
        } else {
            $('#balanceStatus').text('STATUS: TIDAK BALANCE').removeClass('border-success text-success').addClass('border-warning text-warning');
            $('#btnSimpan').prop('disabled', true);
        }
    }

    // Event: Klik tambah baris
    $('#addMoreRow').click(function() {
        addNewRow();
    });

    // Event: Hapus baris
    $(document).on('click', '.remove-row', function() {
        if ($('.jurnal-row').length > 2) {
            $(this).closest('tr').remove();
            checkBalance();
        } else {
            Swal.fire("Info", "Minimal harus ada 2 baris jurnal", "info");
        }
    });

    // Event: Otomatis nol-kan kolom lawan di baris yang sama (UX)
    $(document).on('input', '.input-debit, .input-kredit', function() {
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