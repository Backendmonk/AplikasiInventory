@extends('Admin.template.main')

@section('judul')
    Detail Pembelian
@endsection

@section('Judulisi')
    <h2>Detail Nota Pembelian</h2>
@endsection

@section('Content1')

{{-- ===================== PRINT CSS KHUSUS DOT MATRIX LANDSCAPE ===================== --}}
<style>
@media print {
    @page {
        size: landscape;
        margin: 0.5cm;
    }

    .no-print, nav, header, aside, .sidebar, .navbar, .topbar, footer, .breadcrumb, .btn, .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
        display: none !important;
    }

    .print-area {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .print-area, .print-area table {
        font-family: "Courier New", Courier, monospace !important;
        font-size: 9pt !important;
        color: #000 !important;
    }

    .print-area table {
        width: 100% !important;
        border-collapse: collapse !important;
        table-layout: auto;
    }

    .print-area table th, .print-area table td {
        border: 1px solid #000 !important;
        padding: 3px !important;
        word-wrap: break-word;
    }

    .card { border: none !important; box-shadow: none !important; }
    .card-header { display: none !important; }
    .badge { border: 1px solid #000; color: #000 !important; background: transparent !important; }
}
</style>

<div class="print-area">
    <h3 class="text-center mb-4 no-print">Detail Nota Pembelian – Utama Grafika</h3>

    {{-- ===================== FILTER & ACTION SECTION ===================== --}}
    <div class="card shadow mb-3 no-print">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    {{-- <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Cetak Nota (Dot Matrix)
                    </button> --}}
                </div>
                <div class="col-md-6 text-right">
                    @if(count($pembelianbarang) > 0)
                        <span class="badge badge-info p-2">Nota ID: #{{ $pembelianbarang[0]->notaPembelian->id }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- HEADER INFO NOTA --}}
    @if(count($pembelianbarang) > 0)
        @php $nota = $pembelianbarang[0]->notaPembelian; @endphp
        <div class="card mb-3 border-bottom">
            <div class="card-body">
                <div class="row">
                     <div class="col-md-3 col-sm-6">
                        <strong>Tanggal:</strong><br>
                        {{ $nota->created_at }}
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <strong>ID Nota:</strong><br>
                        {{ $nota->id }}
                    </div>
                  
                    <div class="col-md-3 col-sm-6">
                        <strong>Total:</strong><br>
                        Rp {{ number_format($nota->total,0,',','.') }}
                    </div>

                       <div class="col-md-3 col-sm-6">
                        <strong>Sisa:</strong><br>
                       <span class="text-danger font-weight-bold">Rp {{ number_format($nota->sisa,0,',','.') }}</span>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <strong>Status:</strong><br>
                        @if($nota->status_nota == 'Hutang')
                            <span class="badge bg-warning text-dark">Hutang</span>
                        @elseif($nota->status_nota == 'Selesai')
                            <span class="badge bg-success text-white">Selesai</span>
                        @else
                            <span class="badge bg-secondary text-white">{{ $nota->status_nota }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- ===================== FORM PEMBAYARAN (Hanya Tampil Jika Masih Ada Sisa Hutang) ===================== --}}
    @if(isset($nota) && $nota->sisa > 0)
    <div class="card shadow mb-4 no-print border-left-success">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Form Input Pembayaran</h6>
        </div>
        <div class="card-body">
            <form action="/Admin/Pembelian/PelunasanHutang" method="POST" id="formPembayaran">
                @csrf
                <div class="row">
                    {{-- Input Nominal --}}
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="font-weight-bold">Nominal Pembayaran (Rp)</label>
                            <input type="text" hidden name="id_nota_pembelian" value="{{ $nota->id }}">
                            <input type="text" hidden name="sisa_hutang" id="sisa_hutang" value="{{ $nota->sisa }}">
                            
                            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" placeholder="Masukkan angka saja..." required>
                            <div id="warning_bayar" class="text-danger mt-1" style="display:none; font-size: 0.85rem;">
                                <i class="fas fa-exclamation-circle"></i> <strong>Peringatan:</strong> Nominal melebihi sisa hutang (Rp {{ number_format($nota->sisa,0,',','.') }}).
                            </div>
                        </div>
                    </div>

                    {{-- Pilih Metode --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Metode Bayar</label>
                            <select name="metode_bayar" class="form-control" required>
                                <option value="">-- Pilih Metode --</option>
                                @foreach ($MetodeBayar as $item)
                                     <option value="{{$item->id}}">{{$item->nama_metode}}</option>
                                @endforeach
                                
                          
                            </select>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="col-md-3">
                        <label>&nbsp;</label>
                        <button type="submit" id="btn_bayar" class="btn btn-success btn-block">
                            <i class="fas fa-check"></i> Simpan Pembayaran
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @elseif(isset($nota) && $nota->sisa <= 0)
    <div class="alert alert-success no-print shadow-sm">
        <i class="fas fa-check-circle"></i> <strong>Lunas!</strong> Pembelian ini telah dibayar penuh.
    </div>
    @endif
</div>

    {{-- TABLE DETAIL BARANG --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 no-print">
            <h6 class="m-0 font-weight-bold text-primary">Rincian Barang Pembelian</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="bg-light">
                            <th width="5%">No</th>
                            <th>Nama Barang</th>
                            <th width="15%">Jumlah (Qty)</th>
                            <th width="20%">Harga Satuan</th>
                            <th width="25%">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @forelse($pembelianbarang as $i => $item)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $item->barangBeli->nama_barang ?? '-' }}</td>
                                <td class="text-center">{{ $item->jumlah_beli }}</td>
                                <td>Rp {{ number_format($item->harga_beli,0,',','.') }}</td>
                                <td>Rp {{ number_format($item->subtotal_harga_beli,0,',','.') }}</td>
                            </tr>
                            @php $grandTotal += $item->subtotal_harga_beli; @endphp
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data pembelian</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #f8f9fc;">
                            <th colspan="4" style="text-align:right">TOTAL PEMBELIAN:</th>
                            <th id="footerGrandTotal">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- AREA TANDA TANGAN (Hanya muncul saat cetak) --}}
            <div class="d-none d-print-block mt-5">
                <div class="row">
                    <div class="col-4 text-center">
                        <p>Penerima Barang,</p>
                        <br><br><br>
                        ( ..................... )
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4 text-center">
                        <p>Hormat Kami,</p>
                        <br><br><br>
                        ( ..................... )
                    </div>
                </div>
            </div>
        </div>
    </div>

    

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function() {
    // Inisialisasi DataTable
    if (!$.fn.DataTable.isDataTable('#dataTable')) {
        $('#dataTable').DataTable({
            "paging": false,
            "ordering": true,
            "info": false,
            "searching": false
        });
    }

    // LOGIKA VALIDASI PEMBAYARAN
    @if(isset($nota))
    const sisaHutang = {{ $nota->sisa }};
    
    $('#jumlah_bayar').on('input', function() {
        let nominalInput = parseFloat($(this).val()) || 0;

        if (nominalInput > sisaHutang) {
            // Jika input melebihi sisa
            $('#warning_bayar').show();
            $(this).addClass('is-invalid');
            $('#btn_bayar').prop('disabled', true); // Kunci tombol submit
        } else {
            // Jika valid
            $('#warning_bayar').hide();
            $(this).removeClass('is-invalid');
            $('#btn_bayar').prop('disabled', false); // Aktifkan tombol submit
        }

        // Hindari input minus
        if (nominalInput < 0) {
            $(this).val(0);
        }
    });
    @endif
});
</script>

@endsection