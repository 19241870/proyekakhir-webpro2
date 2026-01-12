@extends('layouts.app')
@section('title', 'Keluhan & Saran Sekolah')

@section('content')
<div class="container my-3">

    {{-- HEADER --}}
    <div class="card border-0 shadow-sm rounded-3 mb-5">
        <div class="card-body d-flex justify-content-between align-items-center p-4">
            <div>
                <h2 class="fw-black text-success mb-1">Keluhan & Saran</h2>
                <small class="text-muted fw-bold">Keluhan & Saran Sekolah MBG Karawang</small>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="bg-light rounded-circle p-2">🔔</div>
                <div class="d-flex align-items-center bg-light rounded-4 px-3 py-2">
                    <div class="text-end me-2">
                        <small class="fw-bold text-success d-block">Pihak Sekolah</small>
                        <small class="text-muted">{{ auth()->user()->sekolah->nama_sekolah }}</small>
                    </div>
                    <div class="bg-success text-white rounded-circle p-2">👤</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- FORM KELUHAN --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-5">
                <div class="card-body p-5">
                    <h4 class="fw-black text-success mb-4">Buat Keluhan & Saran</h4>

                    <form id="formKeluhan" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label text-uppercase fw-bold small text-muted">
                                Tanggal Keluhan
                            </label>
                            <input type="date" name="tanggal" class="form-control rounded py-3">
                        </div>
                        {{-- KATEGORI --}}
                        <div class="mb-4">
                            <label class="form-label text-uppercase fw-bold small text-muted">
                                Kategori Keluhan
                            </label>
                            <select name="kategori" class="form-select rounded py-3">
                                <option selected>-- Pilih Kategori --</option>
                                <option value="Kualitas Makanan">Kualitas Makanan</option>
                                <option value="Keterlambatan">Keterlambatan</option>
                                <option value="Kurang">Kurang</option>
                                <option value="Kebersihan">Kebersihan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="mb-4">
                            <label class="form-label text-uppercase fw-bold small text-muted">
                                Deskripsi Keluhan
                            </label>
                            <textarea name="deskripsi" class="form-control rounded-4 p-4" rows="4"
                                placeholder="Jelaskan keluhan atau saran anda..."></textarea>
                        </div>

                        {{-- UPLOAD --}}
                        <div class="mb-4">
                            <label class="form-label text-uppercase fw-bold small text-muted">
                                Upload Bukti Foto (Opsional)
                            </label>
                            <div class="upload-box" id="uploadBox">
                                <input type="file" id="fotoKeluhan" name="foto" accept="image/*" hidden>
                                <div class="upload-content text-center">
                                    <i class="bi bi-cloud-arrow-up fs-1"></i>
                                    <p class="mb-1 fw-semibold">Drag atau klik untuk upload</p>
                                    <small class="text-muted">Format: JPG, PNG, JPEG (maks 5MB)</small>
                                </div>
                                <img id="previewImage" class="img-preview d-none">
                            </div>
                        </div>

                        {{-- BUTTON --}}
                        <button type="button" id="btnKirimKeluhan"
                            class="btn btn-success w-100 py-3 rounded-pill fw-black text-uppercase shadow">
                            Kirim Keluhan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- STATUS KELUHAN --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-5">
                <div class="card-body p-4">
                    <h6 class="fw-black text-success text-center text-uppercase mb-4">
                        Status Keluhan Saya
                    </h6>

                    <div id="statusKeluhanContainer">
                        <div class="text-center text-muted fst-italic fw-bold">
                            Memuat data...
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@push('js')
{{-- SWEETALERT --}}
<script>
const uploadBox = document.getElementById('uploadBox');
    const fileInput = document.getElementById('fotoKeluhan');
    const previewImage = document.getElementById('previewImage');
    const uploadContent = uploadBox.querySelector('.upload-content');

    uploadBox.addEventListener('click', () => fileInput.click());

    uploadBox.addEventListener('dragover', e => {
        e.preventDefault();
        uploadBox.classList.add('dragover');
    });

    uploadBox.addEventListener('dragleave', () => {
        uploadBox.classList.remove('dragover');
    });

    uploadBox.addEventListener('drop', e => {
        e.preventDefault();
        uploadBox.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        handleFile(file);
    });

    fileInput.addEventListener('change', () => {
        handleFile(fileInput.files[0]);
    });

    function handleFile(file) {
        if (!file || !file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = e => {
                previewImage.src = e.target.result;
                previewImage.classList.remove('d-none');
                uploadContent.classList.add('d-none');
            };
            reader.readAsDataURL(file);
    }

function loadStatusKeluhan() {
    $.get("{{ route('sekolah.keluhan.status') }}", function (res) {

        let html = '';

        if (res.length === 0) {
            html = `
                <div class="border border-2 border-dashed rounded-4 text-center py-4">
                    <small class="text-muted fst-italic fw-bold">
                        Belum ada keluhan
                    </small>
                </div>
            `;
        } else {
            res.forEach(item => {
                let bg = 'secondary';
                let badge = 'bg-secondary';

                if (item.status === 'Belum Diproses') {
                    bg = 'danger';
                    badge = 'bg-danger';
                } 
                else if (item.status === 'Diproses') {
                    bg = 'warning';
                    badge = 'bg-warning text-dark';
                } 
                else if (item.status === 'Selesai') {
                    bg = 'success';
                    badge = 'bg-success';
                }

                html += `
                    <div class="bg-${bg} bg-opacity-10 border-start border-5 border-${bg} rounded-4 p-3 mb-3">
                        <h6 class="fw-bold mb-1">${item.kategori}</h6>
                        <small class="text-muted d-block mb-2">${item.tanggal}</small>
                        <span class="badge ${badge} rounded-pill px-4 py-2">
                            ${item.status}
                        </span>
                    </div>
                `;
            });
        }

        $('#statusKeluhanContainer').html(html);
    });
}

// LOAD AWAL
loadStatusKeluhan();

// AUTO REFRESH TIAP 3 DETIK
setInterval(loadStatusKeluhan, 3000);

$('#btnKirimKeluhan').on('click', function () {
    let form = document.getElementById('formKeluhan');
    let formData = new FormData(form);

    $.ajax({
        url: "{{ route('sekolah.keluhan.store') }}",
        type: "POST",
        dataType: "JSON",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Terkirim!',
                text: res.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: xhr.responseJSON?.message ?? 'Terjadi kesalahan',
            });
        }
    });
});
</script>

@endpush
