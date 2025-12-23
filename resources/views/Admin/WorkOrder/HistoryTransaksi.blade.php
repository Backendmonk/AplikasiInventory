@extends('Admin.template.main')

@section('judul')
  History Transaksi 
@endsection

@section('Judulisi')
    <h2>History Transaksi</h2>
@endsection

@section('Content1')
 
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data History Transaksi</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                           <th>Kode Nota</th>
                                            <th>Total Bayar</th>
                                            <th>Dibayarkan</th>
                                            <th>Sisa</th>
                                            <th>Pertanggal</th>
                                           
                                            
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                       @foreach ($history as $data)
                                            <tr>
                                              <td>{{ $data->idNota }}</td>
                                              <td>Rp {{ number_format($data->totalbayar, 0, ',', '.') }}</td>
                                              <td>Rp {{ number_format($data->dibayarkan, 0, ',', '.') }}</td>
                                              <td>Rp {{ number_format($data->sisa, 0, ',', '.') }}</td>
                                             <td>{{$data->pertanggal}}</td>
                                                                                    
                                            </tr>
                                       @endforeach
                                       
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                  </div>

                  <br>

   

<style>
@media print {

     .sidebar, .navbar, .no-print {
        display: none !important;   /* Sembunyikan sidebar & navbar */
    }
    .content-wrapper, .container, .card {
        margin: 0 !important;
        width: 100% !important;     /* Biar full lebar halaman */
        box-shadow: none !important;
    }

    body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        font-size: 13px;
         background: #fff !important;
    }

    .no-print {
        display: none !important;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }

    /* Hilangin margin container biar full ke kertas */
    .container {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Tambahin footer otomatis di bawah print */
    body:after {
        content: "Dicetak pada: {{ date('d-m-Y H:i') }}";
        display: block;
        text-align: center;
        margin-top: 30px;
        font-size: 11px;
        color: #555;
    }
}
</style>
@endsection
