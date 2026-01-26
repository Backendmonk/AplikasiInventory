@extends('Admin.template.main')

@section('judul')
    Data Penjualan
@endsection

@section('tittleCard')
    <h2 class="no-print">Data Penjualan</h2>
@endsection

@section('Content1')

<style>
@media print {
    @page { size: A4 portrait; margin: 3mm 6mm; }
    html, body { margin: 0 !important; padding: 0 !important; height: auto !important; background-color: #fff !important; overflow: visible !important; }
    .no-print, nav, header, aside, .sidebar, .navbar, .topbar, footer, .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate, .breadcrumb, .content-header, .main-footer, .card-header, .btn { display: none !important; }
    .content-wrapper, .main-content, .container-fluid, .content, .container, .card, .card-body, .table-responsive { margin: 0 !important; padding: 0 !important; width: 100% !important; height: auto !important; overflow: visible !important; border: none !important; box-shadow: none !important; }
    .print-area table { width: 100% !important; border-collapse: collapse !important; table-layout: fixed !important; font-family: "Courier New", Courier, monospace !important; font-size: 7.5pt !important; font-weight: bolder !important; color: #000 !important; }
    .print-area table th, .print-area table td { border: 1px solid #000 !important; padding: 2px !important; word-wrap: break-word !important; }
    th { background-color: #eee !important; -webkit-print-color-adjust: exact; text-align: center !important; }
    .text-right { text-align: right !important; }
    .text-center { text-align: center !important; }
}
.print-area { padding: 15px; }
</style>

<div class="print-area">
    <div class="d-none d-print-block text-center mb-2">
        <h4 style="margin:0; font-weight: bold;">DUTA UTAMA GRAFIKA</h4>
        <p style="margin:0; font-size: 10pt;">Laporan Data Penjualan</p>
        <hr style="border: 1px solid #000; margin-top: 5px; margin-bottom: 5px;">
    </div>

    <h3 class="text-center mb-4 no-print">Laporan Penjualan – Utama Grafika</h3>

    {{-- FILTER SECTION --}}
    <div class="card shadow mb-3 no-print">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label class="font-weight-bold">Filter Mesin (Plat):</label>
                    <select id="filterMesin" class="form-control">
                        <option value="">-- Semua Mesin --</option>
                        <option value="Gramfus">Gramfus</option>
                        <option value="P 52">P 52</option>
                        <option value="P 58">P 58</option>
                        <option value="P 72">P 72</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold">Filter Status:</label>
                    <select id="filterStatus" class="form-control">
                        <option value="">-- Semua Status --</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Piutang">Piutang</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button onclick="window.print()" class="btn btn-primary mr-2">
                        <i class="fas fa-print"></i> Print Laporan
                    </button>
                    <button onclick="location.reload()" class="btn btn-secondary">
                        <i class="fas fa-sync"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 no-print">
            <h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6>
        </div>

        <div class="card-body p-0 p-md-3">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="9%">Tanggal</th>
                            <th width="5%">Nota</th>
                            <th width="12%">Pemesan</th>
                            <th width="8%">Jenis</th>
                            <th width="10%">Detail WO</th>
                            <th width="12%">Penjualan</th>
                            <th width="9%">Ongkos Cetak</th>
                            <th width="7%">Mesin</th>
                            <th width="10%">Total</th>
                            <th width="10%">Bayar</th>
                            <th width="11%">Sisa</th>
                            <th class="d-none">Status Hidden</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nota as $data)
                        <tr>
                            <td class="text-center">{{ date('d/m/Y', strtotime($data['created_at'])) }}</td>
                            <td class="text-center">{{ $data['id'] }}</td>
                            <td>{{ $data->ModelwoRS->nama_pesanan }}</td>
                            <td>{{ $data->ModelwoRS->jenis_pesanan }}</td>
                            <td>
                                @php
                                    $detail = array_filter([
                                        $data->ModelwoRS->jenis_kertas ? "K:{$data->ModelwoRS->jenis_kertas}" : null,
                                        $data->ModelwoRS->warna_tinta ? "T:{$data->ModelwoRS->warna_tinta}" : null,
                                    ]);
                                @endphp
                                {{ implode(' - ', $detail) }}
                            </td>
                            <td>{{ $data->nota->where('barang', '!=', 'Ongkos Cetak')->pluck('barang')->implode(', ') }}</td>
                            
                            <td class="text-right">
                                @php
                                    $itemOngkos = $data->nota->where('barang', 'Ongkos Cetak')->first();
                                    $valOngkos = $itemOngkos ? ($itemOngkos->Harga * $itemOngkos->qty) : 0;
                                @endphp
                                Rp{{ number_format($valOngkos, 0, ',', '.') }}
                            </td>

                            <td class="text-center">{{ $data->ModelwoRS->plat }}</td>
                            <td class="text-right">Rp{{ number_format($data['totalbayar'], 0, ',', '.') }}</td>
                            <td class="text-right">Rp{{ number_format($data['deposit'], 0, ',', '.') }}</td>
                            <td class="text-right">Rp{{ number_format($data['sisapembayaran'], 0, ',', '.') }}</td>
                            <td class="d-none">{{ $data['sisapembayaran'] <= 0 ? 'Selesai' : 'Piutang' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color:#f8f9fc;font-weight:bold;">
                            <th colspan="6" class="text-right">TOTAL:</th>
                            <th class="text-right" id="totalOngkosFooter">Rp0</th> {{-- Total Ongkos Cetak --}}
                            <th></th> {{-- Kosongkan kolom mesin --}}
                            <th class="text-right" id="totalSemuaFooter">Rp0</th> {{-- Total Penjualan --}}
                            <th class="text-right" id="totalBayarFooter">Rp0</th>
                            <th class="text-right" id="totalSisaFooter">Rp0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>

<script>
$(document).ready(function() {
    var table = $('#dataTable').DataTable({
        paging: false,
        ordering: true,
        info: false,
        searching: true,
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\Rp.]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            // Hitung Total Ongkos Cetak (Kolom index 6)
            var totalOngkos = api.column(6, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
            
            // Hitung Total Penjualan (Kolom index 8)
            var totalSemua = api.column(8, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
            
            // Hitung Total Bayar (Kolom index 9)
            var totalBayar = api.column(9, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
            
            // Hitung Total Sisa (Kolom index 10)
            var totalSisa = api.column(10, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);

            var formatIDR = (n) => 'Rp' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            // Update footer
            $('#totalOngkosFooter').html(formatIDR(totalOngkos));
            $('#totalSemuaFooter').html(formatIDR(totalSemua));
            $('#totalBayarFooter').html(formatIDR(totalBayar));
            $('#totalSisaFooter').html(formatIDR(totalSisa));
        }
    });

    $('#filterMesin').on('change', function() {
        table.column(7).search(this.value).draw();
    });

    $('#filterStatus').on('change', function() {
        table.column(11).search(this.value).draw();
    });
});
</script>

@endsection