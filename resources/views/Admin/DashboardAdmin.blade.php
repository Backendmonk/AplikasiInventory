@extends('Admin.template.main')

@section('judul')
    Dashboard
@endsection

@section('Judulisi')
    <h2>Dashboard</h2>
@endsection

@section('Content1')

<div class="row mb-3">
    <div class="col-md-6">
        <form id="filterForm" method="GET" action="{{ route('DashboardAdmin') }}" class="form-inline">
            <div class="form-group mr-2">
                <label for="start">Start</label>
                <input type="date" id="start" name="start" class="form-control ml-2"
                       value="{{ \Carbon\Carbon::parse($start)->format('Y-m-d') }}">
            </div>
            <div class="form-group mr-2">
                <label for="end">End</label>
                <input type="date" id="end" name="end" class="form-control ml-2"
                       value="{{ \Carbon\Carbon::parse($end)->format('Y-m-d') }}">
            </div>

            <button type="submit" class="btn btn-primary">Apply</button>
            <br>
            <br>
            <a href="{{ route('DashboardAdmin') }}" class="btn btn-secondary ml-2">Reset (Bulan Ini)</a>
        </form>
    </div>

    <div class="col-md-6 text-right">
        <h4>Total Penjualan: <span id="totalRange">Rp {{ number_format($totalRange ?? 0,0,',','.') }}</span></h4>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">Pendapatan per Hari</div>
            <div class="card-body">
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">Ringkasan</div>
            <div class="card-body">
                <p>Range: <strong>{{ \Carbon\Carbon::parse($start)->format('d M Y') }} - {{ \Carbon\Carbon::parse($end)->format('d M Y') }}</strong></p>
                <p>Total Penjualan: <strong>Rp {{ number_format($totalRange ?? 0,0,',','.') }}</strong></p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    {{-- Load Chart.js lokal jika ada, kalau tidak pakai CDN (sementara) --}}
    @php
        $localChartPath = public_path('vendor/chart.js/Chart.min.js');
    @endphp

    @if (file_exists($localChartPath))
        <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    @else
        {{-- fallback CDN hanya untuk debugging/dev. Hapus CDN di production jika ingin 100% lokal --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endif

    <style>
    /* Pastikan canvas punya ukuran agar tidak 0 height */
    #revenueChart {
        min-height: 260px;
        max-height: 400px;
        width: 100% !important;
        display: block;
    }
    .card-body.canvas-wrap {
        min-height: 280px; /* agar parent ada ruang */
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data dari server (Blade inject). Pastikan controller mengirim $labels dan $values
        const rawLabels = {!! json_encode($labels ?? []) !!};
        const rawValues = {!! json_encode($values ?? []) !!};

        console.log('DEBUG labels:', rawLabels);
        console.log('DEBUG rawValues:', rawValues);

        // Pastikan values adalah angka
        const values = rawValues.map(v => {
            if (v === null || v === '' || typeof v === 'undefined') return 0;
            const n = Number(String(v).replace(/[^0-9\.\-]/g,''));
            return isNaN(n) ? 0 : n;
        });

        console.log('DEBUG parsed values:', values);

        // format label sederhana (d/m)
        const labels = rawLabels.map(l => {
            try {
                const d = new Date(l);
                if (isNaN(d)) return String(l);
                return d.getDate() + '/' + (d.getMonth()+1);
            } catch(e) { return String(l); }
        });

        const allZero = values.length === 0 ? true : values.every(v => v === 0);

        // Pastikan canvas ada dan parent punya class canvas-wrap untuk min height
        const ctxElem = document.getElementById('revenueChart');
        if (!ctxElem) {
            console.error('Canvas #revenueChart tidak ditemukan di DOM.');
            return;
        }
        const cardBody = ctxElem.closest('.card-body');
        if (cardBody && !cardBody.classList.contains('canvas-wrap')) {
            cardBody.classList.add('canvas-wrap');
        }

        const ctx = ctxElem.getContext('2d');

        // Destroy chart lama jika ada (prevent duplicate)
        if (window._revenueChart instanceof Chart) {
            window._revenueChart.destroy();
        }

        window._revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Penjualan per hari',
                    // jika semua nol, gunakan small values agar sumbu y terlihat
                    data: allZero ? values.map(_ => 0.0001) : values,
                    borderWidth: 1,
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value === 0.0001) return '';
                                return 'Rp ' + Number(value).toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const v = context.parsed.y;
                                if (v === 0.0001) return 'Rp 0';
                                return 'Rp ' + Number(v).toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
    </script>
@endsection
