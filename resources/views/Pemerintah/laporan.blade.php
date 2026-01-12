@extends('layouts.app')

@section('title', 'Dashboard Pemerintah')
@section('page-title', 'Laporan Keluhan Sekolah')

@section('content')
<div class="container-fluid">

    {{-- FILTER --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-end g-3">

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-uppercase text-muted">
                        Periode Laporan
                    </label>
                    <select class="form-select rounded-pill">
                        <option>Harian</option>
                        <option>Mingguan</option>
                        <option>Bulanan</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-uppercase text-muted">
                        Dari Tanggal
                    </label>
                    <input type="date" class="form-control rounded-pill">
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-uppercase text-muted">
                        Sampai Tanggal
                    </label>
                    <input type="date" class="form-control rounded-pill">
                </div>

                <div class="col-md-3 text-end">
                    <button class="btn btn-success px-4 py-2 rounded-pill fw-bold">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary bg-opacity-10">
                <div class="card-body p-4">
                    <small class="fw-bold text-primary text-uppercase">
                        Total Menu Tersalurkan
                    </small>
                    <h2 class="fw-black text-primary mt-2">5.847</h2>
                    <small class="text-muted">Porsi</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-success bg-opacity-10">
                <div class="card-body p-4">
                    <small class="fw-bold text-success text-uppercase">
                        Pemerataan Distribusi
                    </small>
                    <h2 class="fw-black text-success mt-2">94%</h2>
                    <small class="text-muted">Sekolah Terjangkau</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-danger bg-opacity-10">
                <div class="card-body p-4">
                    <small class="fw-bold text-danger text-uppercase">
                        Total Keluhan
                    </small>
                    <h2 class="fw-black text-danger mt-2">{{ $jumlahKeluhan }}</h2>
                    <small class="text-muted">Masalah</small>
                </div>
            </div>
        </div>

    </div>

    {{-- CHART --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h6 class="fw-bold text-success text-uppercase mb-4">
                Keluhan Per Kategori
            </h6>
            <div style="height:300px">
                <canvas id="complaintChart"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const complaintLabels = @json($labels);
    const complaintData   = @json($data);
const ctx = document.getElementById('complaintChart').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: complaintLabels,
        datasets: [{
            data: complaintData,
            backgroundColor: '#1f5132',
            borderRadius: 10,
            barThickness: 30,
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: { color: '#f1f1f1' }
            },
            y: {
                grid: { display: false }
            }
        }
    }
});

</script>
@endsection
