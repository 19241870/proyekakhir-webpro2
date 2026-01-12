@extends('layouts.app')
@section('title', 'Dashboard Pemerintah')
{{-- @section('page-title', 'Menu Sekolah') --}}

@section('content')

<div class="container-xl">

    <!-- HEADER -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-black text-success mb-1">Menu Mingguan</h3>
                <small class="text-muted fw-bold">
                    Menu Makanan MBG Sekolah
                </small>
            </div>

            <div class="d-flex align-items-center gap-3 bg-light px-4 py-2 rounded-pill">
                <div class="text-end">
                    <small class="fw-black text-success d-block">Pihak Sekolah</small>
                    <small class="text-muted fw-bold">
                        {{ auth()->user()->sekolah->nama_sekolah }}
                    </small>
                </div>
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                     style="width:42px;height:42px">
                    <i class="bi bi-person"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- KONTEN -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-lg-5">

            <h4 class="fw-black text-success mb-4">
                Menu Mingguan MBG
            </h4>

            <div class="row g-4" id="menuContainer">
                <!-- AJAX CONTENT -->
            </div>

        </div>
    </div>

</div>

@endsection
@push('js')
<script>
$(document).ready(function () {

    function loadMenu() {
        $.get("{{ route('sekolah.menu.data') }}", function (res) {

            let html = '';

            if (!res || res.length === 0) {
                html = `
                    <div class="col-12 text-center text-muted fw-bold py-5">
                        Belum ada menu tersedia
                    </div>`;
            } else {
                res.forEach(m => {
                    html += `
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm rounded-4">
                            <div class="card-body text-center">
                                <h5 class="fw-black text-success mb-3">${m.hari}</h5>
                                <p class="fw-bold text-secondary mb-4">${m.menu}</p>
                                <hr>
                                <small class="text-muted fw-bold d-block">
                                    Kalori: <span class="text-dark">${m.kalori} kcal</span>
                                </small>
                                <small class="text-muted fw-bold">
                                    Protein: <span class="text-dark">${m.protein} g</span>
                                </small>
                            </div>
                        </div>
                    </div>`;
                });
            }

            const container = document.getElementById('menuContainer');
            if (container) {
                container.innerHTML = html;
            }
        });
    }

    loadMenu();
    setInterval(loadMenu, 3000);

});
</script>
@endpush


