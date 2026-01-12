@extends('layouts.app')

@section('content')
<div class="container py-3">

    {{-- HEADER --}}
    <div class="mb-4">
        <h1 class="fw-black display-6 text-success-emphasis">Riwayat Laporan</h1>
        <p class="text-muted">Klik tanda panah untuk mengubah status verifikasi</p>
    </div>

    {{-- CARD --}}
    <div class="bg-white border shadow-sm rounded-5 p-5">

        {{-- FILTER --}}
        <div class="mb-4 col-md-4">
            <label class="form-label fw-bold">Filter Periode</label>
            <select id="filterPeriode" class="form-select form-select-lg rounded-pill">
                <option value="all">Semua Periode</option>
                <option value="today">Hari Ini</option>
                <option value="week">7 Hari Terakhir</option>
                <option value="month">Bulan Ini</option>
            </select>
        </div>


        {{-- LIST --}}
        <div id="laporanList" class="d-flex flex-column gap-3"></div>
        
        {{-- PAGINATION --}}
        <div class="d-flex justify-content-between mt-4">
            <button id="prevPage" class="btn btn-outline-secondary rounded-pill px-4" disabled>
                ← Previous
            </button>
            <button id="nextPage" class="btn btn-outline-secondary rounded-pill px-4" disabled>
                Next →
            </button>
        </div>
    </div>
</div>

{{-- STYLE TAMBAHAN --}}
<style>
    .hover-shadow:hover {
        box-shadow: 0 .75rem 1.5rem rgba(0,0,0,.08);
    }
    .rotate-btn:hover {
        background-color: #064E3B;
        color: #fff;
        transform: rotate(90deg);
        transition: all .3s ease;
    }
</style>
@endsection
@push('js')
<script>
let currentUrl = "{{ route('sekolah.riwayat.data') }}";
let currentPeriode = 'all';

function loadLaporan(url) {
    $.get(url, { periode: currentPeriode }, function (res) {

        let html = '';

        if (res.data.length === 0) {
            html = `<div class="text-center text-muted py-5">
                        Tidak ada laporan pada periode ini
                    </div>`;
        }

        res.data.forEach(item => {
            html += `
            <div class="d-flex justify-content-between align-items-center p-4 border rounded-4 shadow-sm">

                <div class="d-flex align-items-center gap-4">
                    <div class="d-flex align-items-center justify-content-center rounded-4
                        ${item.status === 'Terverifikasi' ? 'bg-success text-white' : 'bg-light'}"
                        style="width:56px;height:56px;">
                        🍱
                    </div>

                    <div>
                        <h6 class="fw-bold mb-1">${item.menu?.nama_menu ?? '-'}</h6>
                        <small class="text-muted">
                            ${item.tanggal} • ${item.jumlah_porsi} Porsi
                        </small>
                    </div>
                </div>

                <span class="badge rounded-pill px-4 py-2 text-uppercase
                    ${item.status === 'Terverifikasi' ? 'bg-success-subtle text-success' :
                      item.status === 'Pending' ? 'bg-warning-subtle text-warning' :
                      'bg-secondary-subtle text-secondary'}"
                    style="font-size:10px;letter-spacing:2px;">
                    ${item.status}
                </span>
            </div>`;
        });

        $('#laporanList').html(html);

        $('#prevPage').prop('disabled', !res.prev_page_url)
                      .data('url', res.prev_page_url);

        $('#nextPage').prop('disabled', !res.next_page_url)
                      .data('url', res.next_page_url);

        currentUrl = url;
    });
}


// INIT LOAD
loadLaporan(currentUrl);

// BUTTON EVENTS
$('#nextPage').click(function () {
    const url = $(this).data('url');
    if (url) loadLaporan(url);
});

$('#prevPage').click(function () {
    const url = $(this).data('url');
    if (url) loadLaporan(url);
});
$('#filterPeriode').change(function () {
    currentPeriode = $(this).val();
    loadLaporan("{{ route('sekolah.riwayat.data') }}");
});

</script>
@endpush
