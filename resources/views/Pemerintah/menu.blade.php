@extends('layouts.app')

@section('title', 'Kelola Menu MBG')
@section('page-title', 'Kelola Menu MBG')

@section('content')

<style>
.menu-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 24px;
    padding: 20px 15px;
    text-align: center;
    transition: all .3s ease;
}
.menu-card.active {
    border-color: #4ade80;
    box-shadow: 0 10px 15px rgba(74,222,128,.15);
}
.day-badge {
    font-size: 12px;
    font-weight: 800;
    color: #1a4d2e;
    letter-spacing: 1px;
    margin-bottom: 12px;
    display: block;
}
.makanan-text {
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    min-height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.stats-text {
    font-size: 11px;
    color: #9ca3af;
    font-weight: 600;
}
.stats-value {
    font-weight: 800;
    color: #111827;
}
.btn-edit-pill {
    background: #4ade80;
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    padding: 4px 18px;
    border-radius: 999px;
    margin-top: 14px;
}
.btn-edit-pill:hover { background: #166534; }
.input-inline {
    width: 100%;
    background: #f3f4f6;
    border: none;
    border-radius: 8px;
    padding: 6px;
    font-size: 11px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 6px;
}
.hidden-mode { display: none; }
</style>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="row">

        {{-- NAV VERTICAL --}}
        <div class="col-md-3">
            <div class="nav flex-column nav-pills gap-2" role="tablist">
                <button class="nav-link active fw-bold rounded-4"
                        data-bs-toggle="pill"
                        data-bs-target="#tab-hari">
                    📅 Hari & Tanggal
                </button>

                <button class="nav-link fw-bold rounded-4"
                        data-bs-toggle="pill"
                        data-bs-target="#tab-menu">
                    🍱 Kelola Menu
                </button>
            </div>
        </div>

        {{-- TAB CONTENT --}}
        <div class="col-md-9">
            <div class="tab-content">

                {{-- TAB HARI --}}
                <div class="tab-pane fade show active" id="tab-hari">
                    <h5 class="fw-black text-success mb-4">
                        Manajemen Hari & Tanggal
                    </h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" onchange="setHari()" class="form-control rounded">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Hari</label>
                            <input type="text" id="hari" name="hari" class="form-control rounded" readonly placeholder="Contoh: Senin">
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-sm align-middle table-hover" id="tbl_hari">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Hari</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="hariTable">
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">
                                            Belum ada data
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-12 mt-3">
                            <button type="button" id="btnSimpanHari" class="btn btn-success rounded-pill px-4 fw-bold">
                                Simpan Hari
                            </button>
                        </div>
                    </div>
                </div>

                {{-- TAB MENU --}}
                <div class="tab-pane fade" id="tab-menu">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-black text-success mb-0">
                            Kelola Menu Harian
                        </h5>

                        <div class="d-flex gap-2">
                            <button onclick="showPilihSekolah()"
                                class="btn btn-outline-success fw-bold rounded px-4">
                                <i class="bi bi-eye me-1"></i> Detail
                            </button>

                            <button data-bs-toggle="modal"
                                data-bs-target="#modalTambahMenu"
                                class="btn btn-success fw-bold rounded px-4">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Menu
                            </button>
                        </div>

                    </div>

                    <div id="menuTableSection">
                        <div class="table-responsive">
                            <table id="menuTable" class="table table-striped table-bordered align-middle w-100">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th width="40">No</th>
                                        <th>Tanggal</th>
                                        <th>Hari</th>
                                        <th>Sekolah</th>
                                        <th>Menu</th>
                                        <th>Kalori</th>
                                        <th>Protein</th>
                                        <th>Status</th>
                                        <th width="120">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menus as $i => $m)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($m->hari->tanggal)->format('d-m-Y') }}</td>
                                        <td>{{ $m->hari->hari }}</td>
                                        <td>{{ $m->sekolah->nama_sekolah }}</td>
                                        <td class="fw-bold">{{ $m->nama_menu }}</td>
                                        <td class="text-center">{{ $m->kalori }} kcal</td>
                                        <td class="text-center">{{ $m->protein }} g</td>
                                        <td class="text-center">
                                            <span class="badge {{ $m->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $m->is_active ? 'AKTIF' : 'NONAKTIF' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button onclick="editMenu({{ $m->id }})"
                                                class="btn btn-sm btn-warning rounded-pill px-3">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button onclick="deleteMenu({{ $m->id }})"
                                                class="btn btn-sm btn-danger rounded-pill px-3">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="menuDetailSection" class="d-none">

                        <button class="btn btn-outline-secondary mb-3"
                            onclick="backToTable()">
                            ← Kembali
                        </button>

                        <h5 class="fw-black text-success mb-4" id="judulDetail"></h5>

                        <div class="row g-3" id="menuCardContainer"></div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- MODAL TAMBAH MENU -->
<div class="modal fade" id="modalTambahMenu" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-black text-success">
                    Tambah Menu MBG
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formTambahMenu">
                @csrf
                <div class="modal-body px-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Hari / Tanggal</label>
                            <select name="mbg_hari_id" class="form-select rounded" required>
                                <option value="">-- Pilih Hari --</option>
                                @foreach($hariAktif as $h)
                                    <option value="{{ $h->id }}">
                                        {{ $h->hari }} - {{ \Carbon\Carbon::parse($h->tanggal)->format('d-m-Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sekolah</label>
                            <select name="sekolah_id" class="form-select rounded" required>
                                <option value="">-- Pilih Sekolah --</option>
                                @foreach($sekolah as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_sekolah }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Nama Menu</label>
                            <textarea name="nama_menu" class="form-control rounded" rows="2" required></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kalori (kcal)</label>
                            <input type="number" name="kalori" class="form-control rounded" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Protein (gram)</label>
                            <input type="number" name="protein" class="form-control rounded" required>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" checked>
                                <label class="form-check-label fw-bold">Aktifkan Menu</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-0 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-5 fw-bold">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT MENU -->
<div class="modal fade" id="modalEditMenu" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-black text-success">
                    Edit Menu MBG
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formEditMenu">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_id">

                <div class="modal-body px-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Hari / Tanggal</label>
                            <select name="mbg_hari_id" id="edit_hari" class="form-select rounded-pill">
                                @foreach($hariAktif as $h)
                                    <option value="{{ $h->id }}">
                                        {{ $h->hari }} - {{ \Carbon\Carbon::parse($h->tanggal)->format('d-m-Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sekolah</label>
                            <select name="sekolah_id" id="edit_sekolah" class="form-select rounded-pill">
                                @foreach($sekolah as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_sekolah }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Nama Menu</label>
                            <textarea name="nama_menu" id="edit_menu"
                                class="form-control rounded-4" rows="2"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kalori</label>
                            <input type="number" name="kalori" id="edit_kalori"
                                class="form-control rounded-pill">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Protein</label>
                            <input type="number" name="protein" id="edit_protein"
                                class="form-control rounded-pill">
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                    id="edit_active" name="is_active">
                                <label class="form-check-label fw-bold">Aktif</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-0 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-5 fw-bold">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPilihSekolah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-black text-success">
                    Pilih Sekolah
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="list-group">
                    @foreach($sekolah as $s)
                        <button class="list-group-item list-group-item-action"
                            onclick="loadDetailSekolah({{ $s->id }}, '{{ $s->nama_sekolah }}')">
                            {{ $s->nama_sekolah }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
$(document).ready(function () {
    $('#menuTable').DataTable({
        pageLength: 10,
        ordering: true,
        responsive: true,
        language: {
            search: "Cari Menu:",
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "‹",
                next: "›"
            }
        }
    });

    // TAMBAH MENU
    $('#formTambahMenu').submit(function(e){
        e.preventDefault();

        $.ajax({
            url: "{{ route('pemerintah.menu') }}",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res){
                $('#modalTambahMenu').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                // reload datatable / halaman
                setTimeout(() => {
                    location.reload();
                    // atau table.ajax.reload();
                }, 2000);
            },
            error: function(xhr){
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                });
            }
        });
    });

    $('#formEditMenu').submit(function(e){
        e.preventDefault();
        const id = $('#edit_id').val();

        $.ajax({
            url: "{{ route('pemerintah.menu') }}/"+id,
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res){
                $('#modalEditMenu').modal('hide');
                 Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                // reload datatable / halaman
                setTimeout(() => {
                    location.reload();
                    // atau table.ajax.reload();
                }, 2000);
            },
            error: function(xhr){
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                });
            }
        });
    });

});

// SHOW DETAIL SEKOLAH
function showPilihSekolah() {
    $('#modalPilihSekolah').modal('show');
}

function backToTable() {
    $('#menuDetailSection').addClass('d-none');
    $('#menuTableSection').removeClass('d-none');
}

function loadDetailSekolah(sekolahId, namaSekolah) {
    $('#modalPilihSekolah').modal('hide');
    $('#menuTableSection').addClass('d-none');
    $('#menuDetailSection').removeClass('d-none');

    $('#judulDetail').text('Menu MBG - ' + namaSekolah);

    $.get("{{ route('pemerintah.menu.by_sekolah') }}",
        { sekolah_id: sekolahId },
        function(res){
            let html = '';

            if (res.data.length === 0) {
                html = `<div class="col-12 text-muted text-center">
                            Belum ada menu
                        </div>`;
            } else {
                res.data.forEach(m => {
                    html += `
                    <div class="col-md-4">
                        <div class="menu-card ${m.is_active ? 'active' : ''}">
                            <span class="day-badge">
                                ${m.hari} <br>
                                <small>${m.tanggal}</small>
                            </span>

                            <div class="makanan-text">
                                ${m.nama_menu}
                            </div>

                            <div class="mt-2">
                                <div class="stats-text">
                                    Kalori:
                                    <span class="stats-value">
                                        ${m.kalori} kcal
                                    </span>
                                </div>
                                <div class="stats-text">
                                    Protein:
                                    <span class="stats-value">
                                        ${m.protein} g
                                    </span>
                                </div>
                            </div>

                            <span class="badge mt-3 ${
                                m.is_active ? 'bg-success' : 'bg-secondary'
                            }">
                                ${m.is_active ? 'AKTIF' : 'NONAKTIF'}
                            </span>
                        </div>
                    </div>`;
                });
            }

            $('#menuCardContainer').html(html);
        }
    );
}

// EDIT MENU
    function editMenu(id){
        $.get("{{ route('pemerintah.menu') }}/"+id, function(res){
            $('#edit_id').val(res.id);
            $('#edit_hari').val(res.mbg_hari_id);
            $('#edit_sekolah').val(res.sekolah_id);
            $('#edit_menu').val(res.nama_menu);
            $('#edit_kalori').val(res.kalori);
            $('#edit_protein').val(res.protein);
            $('#edit_active').prop('checked', res.is_active == 1);

            $('#modalEditMenu').modal('show');
        });
    }
// DELETE MENU
function deleteMenu(id){
    Swal.fire({
        title: 'Hapus Menu?',
        text: 'Data menu akan dihapus secara permanen',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus'
    }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('pemerintah.menu') }}/"+id,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: 'DELETE'
                },
                success: function(res){
                    Swal.fire('Berhasil', res.message, 'success');

                    // reload datatable / halaman
                    setTimeout(() => {
                        location.reload();
                        // atau table.ajax.reload();
                    }, 2000);
                },
                error: function(){
                    Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                }
            });
        }
    });
}
function setHari() {
    const tanggal = document.getElementById('tanggal').value;
    if (!tanggal) return;

    const days = [
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu'
    ];

    const dateObj = new Date(tanggal);
    const hari = days[dateObj.getDay()];

    document.getElementById('hari').value = hari;
}

// loadhari
function loadHari() {
    fetch("{{ route('pemerintah.menu.list_hari') }}")
        .then(res => res.json())
        .then(data => {
            let html = '';

            if (data.length === 0) {
                html = `<tr>
                    <td colspan="3" class="text-center text-muted">
                        Belum ada data
                    </td>
                </tr>`;
            } else {
                data.forEach(row => {
                    html += `
                        <tr>
                            <td>
                               <input type="date"
                                    class="form-control form-control-sm"
                                    value="${row.tanggal}"
                                    onchange="updateHari(${row.id}, this.value)">
                            </td>
                            <td>${row.hari}</td>
                            <td>
                                 <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        ${row.is_active ? 'checked' : ''}
                                        onchange="toggleHari(${row.id})">
                                </div>
                            </td>
                            <td class="text-center">
                                <button onclick="deleteHari(${row.id})"
                                    class="btn btn-sm btn-danger rounded-pill px-3">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }

            document.getElementById('hariTable').innerHTML = html;
        });
}
document.addEventListener('DOMContentLoaded', loadHari);
document.getElementById('btnSimpanHari').addEventListener('click', function () {
    const tanggal = document.getElementById('tanggal').value;

    if (!tanggal) {
        Swal.fire('Error', 'Tanggal wajib diisi', 'error');
        return;
    }

    fetch("{{ route('pemerintah.menu.store_hari') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ tanggal })
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            Swal.fire('Berhasil', 'Hari berhasil ditambahkan', 'success');
            document.getElementById('tanggal').value = '';
            document.getElementById('hari').value = '';
            loadHari();
        }
    })
    .catch(err => {
        Swal.fire('Gagal', 'Tanggal sudah terdaftar', 'error');
    });
});

// toggle hari
function toggleHari(id) {
    fetch("{{ route('pemerintah.menu.toggle_hari') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    })
    .then(res => res.json())
    .then(res => {
        swalSuccess(res.message);
        location.reload();
    })
    .catch(() => swalError());
}

function swalSuccess(message) {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: message,
        timer: 3000,
        showConfirmButton: false
    });
}

function swalError(message = 'Terjadi kesalahan') {
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: message
    });
}

// update hari
function updateHari(id, tanggal) {
    fetch("{{ route('pemerintah.menu.update_hari') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id, tanggal })
    })
    .then(res => res.json())
    .then(res => {
        swalSuccess(res.message);
        location.reload();
    })
    .catch(() => swalError());
}
// hapus hari
function deleteHari(id) {
    Swal.fire({
        title: 'Hapus Hari?',
        text: 'Data menu terkait juga akan terhapus',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus'
    }).then(result => {
        if (result.isConfirmed) {
            fetch("{{ route('pemerintah.menu.delete_hari') }}/" + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(() => {
                Swal.fire('Berhasil', 'Hari dihapus', 'success');
                loadHari();
            });
        }
    });
}
</script>
@endpush
