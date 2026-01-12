@extends('layouts.app')

@section('title', 'Beranda Sekolah')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid">

    {{-- HERO CARD --}}
    <div class="card border-0 shadow-lg mb-4"
         style="background:#1a4d2e;border-radius:40px;">
        <div class="card-body p-5 position-relative overflow-hidden">

            <div class="position-relative" style="z-index:2;max-width:600px;">
                <h1 class="fw-bold fst-italic text-white mb-2 display-6">
                    Selamat Datang!
                </h1>
                <p class="text-white-50 fw-semibold mb-4">
                    Kelola laporan MBG sekolah anda dengan mudah dan cepat
                </p>

                <a href="{{ route('sekolah.input_laporan') }}"
                   class="btn btn-warning fw-bold px-5 py-3 rounded-pill shadow">
                    Buat Laporan Sekarang
                </a>
            </div>

            <div class="position-absolute top-0 end-0 translate-middle-y"
                 style="width:300px;height:300px;background:rgba(255,255,255,.05);border-radius:50%;">
            </div>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="stat-card green">
                <div>
                    <small class="text-uppercase text-muted fw-bold">Laporan Bulan Ini</small>
                    <h3 class="fw-bold mt-1">{{ $jumlahLaporanBulanIni }}</h3>
                    <small class="text-success fw-semibold">Laporan Lengkap</small>
                </div>
                <div class="bg-success bg-opacity-10 rounded-3 p-3 fs-3">
                    📄
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card blue">
                <div>
                    <small class="text-uppercase text-muted fw-bold">Siswa Terlayani</small>
                    <h3 class="fw-bold mt-1">{{ $jumlahSiswaPorsi}}</h3>
                    <small class="text-primary fw-semibold">Terdaftar di MBG</small>
                </div>
                <div class="bg-primary bg-opacity-10 rounded-3 p-3 fs-3">
                    👥
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card yellow">
                <div>
                    <small class="text-uppercase text-muted fw-bold">Rating Puas</small>
                    <h3 class="fw-bold mt-1">{{ $jumlahRating }} / 5</h3>
                    <small class="text-warning fw-semibold">Dari Siswa</small>
                </div>
                <div class="bg-warning bg-opacity-10 rounded-3 p-3 fs-3">
                    ⭐
                </div>
            </div>
        </div>

    </div>

    {{-- CHART SECTION --}}
    <div class="row g-4">

        {{-- BAR CHART --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100"
                 style="border-radius:20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-light rounded-3 p-2 me-2 fs-5">📊</div>
                        <h6 class="fw-bold text-uppercase mb-0">
                            Laporan Per Minggu
                        </h6>
                    </div>
                    <div style="height:300px;">
                        <canvas id="barChartMingguan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- PIE CHART --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100"
                 style="border-radius:20px;">
                <div class="card-body p-4 text-center">
                    <h6 class="fw-bold text-uppercase mb-4">
                        Jenis Menu
                    </h6>

                    <div style="height:250px;">
                        <canvas id="pieChartMenu"></canvas>
                    </div>

                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-3 small fw-bold text-muted">
                        <span><i class="bi bi-circle-fill text-purple"></i> Ayam</span>
                        <span><i class="bi bi-circle-fill text-warning"></i> Daging</span>
                        <span><i class="bi bi-circle-fill text-primary"></i> Ikan</span>
                        <span><i class="bi bi-circle-fill text-danger"></i> Telur</span>
                    </div>
                </div>
            </div>
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

{{-- CHART SCRIPT --}}
<script>
    const ctxBar = document.getElementById('barChartMingguan');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Minggu 1','Minggu 2','Minggu 3','Minggu 4'],
            datasets: [
                { label: 'Selesai', data: [90,85,95,80], backgroundColor: '#a78bfa', borderRadius: 8 },
                { label: 'Tertunda', data: [10,15,5,20], backgroundColor: '#fca5a5', borderRadius: 8 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true },
                x: { grid: { display: false } }
            }
        }
    });

    const ctxPie = document.getElementById('pieChartMenu');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Ayam','Daging','Ikan','Telur'],
            datasets: [{
                data: [40,20,25,15],
                backgroundColor: ['#8b5cf6','#fb923c','#60a5fa','#f87171']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush

