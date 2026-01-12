@extends('layouts.app')
@section('page_title', 'Manajemen Keluhan')

@section('content')

<style>
    .complaint-card {
        transition: all .3s ease;
        cursor: pointer;
        border-radius: 20px;
    }
    .complaint-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,.08);
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .5px;
    }
    .status-processed {
        background: #FEF08A;
        color: #854D0E;
    }
    .status-completed {
        background: #DBEAFE;
        color: #1E40AF;
    }
</style>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4 p-lg-5">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-black text-success mb-1">Manajemen Keluhan</h3>
                <small class="text-muted fw-bold text-uppercase">
                    Pantau dan kelola semua keluhan dari sekolah
                </small>
            </div>

            <div class="bg-light px-4 py-2 rounded-pill border">
                <small class="fw-bold text-uppercase text-muted">
                    Total Keluhan:
                    <span class="text-success fs-6">{{ $jumlahKeluhan }}</span>
                </small>
            </div>
        </div>

        <!-- LIST -->
        <div class="vstack gap-3" id="keluhanContainer">
            <div class="text-center text-muted fst-italic">
                Memuat data keluhan...
            </div>
        </div>

    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalKeluhan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-success">Detail Keluhan</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit-id">

                <div class="mb-3">
                    <label class="form-label small fw-bold text-uppercase">Nama Sekolah</label>
                    <input id="edit-sekolah" class="form-control rounded-pill" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-uppercase">Kategori</label>
                    <input id="edit-kategori" class="form-control rounded-pill" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-uppercase">Isi Keluhan</label>
                    <textarea id="edit-pesan" rows="3" class="form-control rounded-3" readonly></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-uppercase">Foto</label><br>
                    <img id="edit-foto" class="img-fluid rounded-3 border" style="max-height:200px">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-uppercase">Status</label>
                    <select id="edit-status" class="form-select rounded-pill">
                        <option value="Diproses">⚠️ Diproses</option>
                        <option value="Selesai">✅ Selesai</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light rounded-pill" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-success rounded-pill" onclick="saveKeluhan()">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
    function openKeluhanModal(id) {
    $.get(`/pemerintah/keluhan/${id}`, function (res) {

        $('#edit-id').val(res.id);
        $('#edit-sekolah').val(res.nama_sekolah);
        $('#edit-kategori').val(res.kategori);
        $('#edit-pesan').val(res.deskripsi);
        $('#edit-status').val(res.status);

        if (res.foto) {
            $('#edit-foto').attr('src', `/storage/${res.foto}`);
        } else {
            $('#edit-foto').attr('src', '/img/no-image.png');
        }

        $('#modalKeluhan').modal('show');
    });
}
    function loadKeluhan() {
    $.get("{{ route('pemerintah.keluhan.data') }}", function (res) {

        let html = '';

        if (res.length === 0) {
            html = `
                <div class="text-center text-muted fst-italic py-4">
                    Belum ada keluhan masuk
                </div>
            `;
        }

        res.forEach(k => {

            let statusClass = 'bg-secondary';
            let badgeClass  = 'bg-secondary';

            if (k.status === 'Belum Diproses') {
                statusClass = 'bg-danger';
                badgeClass  = 'bg-danger';
            } else if (k.status === 'Diproses') {
                statusClass = 'bg-warning';
                badgeClass  = 'bg-warning text-dark';
            } else if (k.status === 'Selesai') {
                statusClass = 'bg-success';
                badgeClass  = 'bg-success';
            }

            html += `
                <div class="complaint-card p-4 border rounded-4"
                    onclick="openKeluhanModal(
                        '${k.id}',
                        '${k.sekolah}',
                        '${k.kategori}',
                        '${k.pesan}',
                        '${k.status}'
                    )">

                    <div class="d-flex justify-content-between align-items-start">

                        <div class="d-flex gap-3">
                            <div class="bg-white border rounded-3 d-flex align-items-center justify-content-center"
                                style="width:48px;height:48px">
                                <span class="fs-4">${k.icon}</span>
                            </div>

                            <div>
                                <h6 class="fw-bold mb-0">${k.sekolah}</h6>
                                <small class="text-muted fw-bold text-uppercase">
                                    ${k.kategori}
                                </small>
                                <p class="fst-italic text-secondary mt-2 mb-0">
                                    "${k.pesan}"
                                </p>
                            </div>
                        </div>

                        <div class="text-end">
                            <span class="badge ${badgeClass} rounded-pill px-4 py-2">
                                ${k.status}
                            </span>
                            <div class="small text-muted fw-bold mt-2">
                                ${k.tanggal}
                            </div>
                        </div>

                    </div>
                </div>
            `;
        });

        $('#keluhanContainer').html(html);
    });
}

// initial load
loadKeluhan();

// 🔄 realtime polling (tiap 3 detik)
setInterval(loadKeluhan, 3000);
    // let modal;

    // function openKeluhanModal(id, sekolah, kategori, pesan, status) {
    //     modal = new bootstrap.Modal(document.getElementById('modalKeluhan'));
    //     modal.show();

    //     editId.value = id;
    //     editSekolah.value = sekolah;
    //     editKategori.value = kategori;
    //     editPesan.value = pesan;
    //     editStatus.value = status;
    // }

function saveKeluhan() {
    let id = $('#edit-id').val();

    $.ajax({
        url: `/pemerintah/keluhan/${id}`,
        type: 'PUT',
        data: {
            _token: '{{ csrf_token() }}',
            status: $('#edit-status').val()
        },
        success: function (res) {
            $('#modalKeluhan').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message,
                timer: 2500,
                showConfirmButton: false
            });
            loadKeluhan(); // reload tabel
        }
    });
}
</script>
@endpush
