@extends('layouts.app')

@section('title', 'Dashboard Pemerintah')
@section('page-title', 'Dashboard Monitoring')

@section('content')

<div class="row g-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card green">
            <div>
                <p>Total Sekolah</p>
                <h3>{{ $jumlahSekolah }}</h3>
                <small>Peserta MBG</small>
            </div>
            <i class="bi bi-building"></i>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card blue">
            <div>
                <p>Laporan Hari Ini</p>
                <h3>118/125</h3>
                <small>94% Lengkap</small>
            </div>
            <i class="bi bi-file-earmark-text"></i>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card yellow">
            <div>
                <p>Total Keluhan</p>
                <h3>{{ $jumlahKeluhan }}</h3>
                <small>Menunggu Tindak Lanjut</small>
            </div>
            <i class="bi bi-exclamation-triangle"></i>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card purple">
            <div>
                <p>Siswa Terlayani</p>
                <h3>47.5K</h3>
                <small>Bulan Ini</small>
            </div>
            <i class="bi bi-people"></i>
        </div>
    </div>
</div>

<div class="row g-4 mt-3">
    <div class="col-lg-7">
        <div class="card chart-card">
            <h6 class="fw-bold mb-3">Distribusi Harian</h6>
            <canvas id="lineChart"></canvas>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card chart-card">
            <h6 class="fw-bold mb-3">Persentase Laporan</h6>
            <canvas id="donutChart"></canvas>
        </div>
    </div>
</div>

@endsection

@push('js')
@if(session('swal'))
<script>
    Swal.fire({
        icon: '{{ session('swal.icon') }}',
        title: '{{ session('swal.title') }}',
        text: '{{ session('swal.text') }}',
        timer: 2500,
        showConfirmButton: false
    });
</script>
@endif

<script>
    new Chart(lineChart, {
        type: 'line',
        data: {
            labels: ['Sen','Sel','Rab','Kam','Jum'],
            datasets: [{
                label: 'Porsi Terdistribusi',
                data: [5800,5900,5700,5850,6000],
                borderWidth: 3,
                tension: .4
            }]
        }
    });

    new Chart(donutChart, {
        type: 'doughnut',
        data: {
            labels: ['Lengkap','Belum'],
            datasets: [{ data: [94,6] }]
        }
    });
</script>
@endpush
