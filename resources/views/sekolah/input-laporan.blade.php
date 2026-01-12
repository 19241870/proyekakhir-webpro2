@extends('layouts.app')

@section('title', 'Laporan Harian')
@section('page-title', 'Input Laporan Harian')

@section('content')
<div class="container-fluid py-4">

    {{-- TITLE --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-0" style="color:#1f5132;">Input Laporan Harian</h4>
        <small class="text-muted">Dashboard Sekolah MBG Karawang</small>
    </div>

    {{-- CARD FORM --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-lg-5">

            <h5 class="fw-bold mb-4" style="color:#1f5132;">Input Laporan Harian</h5>

            <form id="formLaporan" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">

                    {{-- TANGGAL --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Laporan</label>
                        <input type="date"
                            name="tanggal"
                            id="tanggal"
                            class="form-control rounded-3"
                            required>
                    </div>
                    {{-- Jam lapor --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jam Lapor</label>
                        <input type="time"
                            name="jam_lapor"
                            id="jam_lapor"
                            class="form-control rounded-3"
                            required>
                    </div>
                    {{-- MENU --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Menu Hari Ini</label>
                        <select name="menu_id"
                                id="menu_id"
                                class="form-select rounded-3"
                                required>
                            <option selected disabled>-- Pilih Menu --</option>
                            @foreach($menus as $menu)
                                <option value="{{ $menu->id }}">
                                    {{ $menu->nama_menu }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- JUMLAH PORSI --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jumlah Porsi Dari Pemerintah</label>
                        <input type="number"
                            id="porsi_pemerintah"
                            value="{{ $jumlahPorsiPemerintah }}"
                            class="form-control rounded-3"
                            readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jumlah Porsi Diterima</label>
                        <input type="number"
                            name="jumlah_porsi"
                            id="porsi_diterima"
                            class="form-control rounded-3"
                            min="0"
                            max="{{ $jumlahPorsiPemerintah }}"
                            placeholder="Contoh: 450"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jumlah Sisa</label>
                        <input type="number"
                            name="jumlah_sisa"
                            id="jumlah_sisa"
                            class="form-control rounded-3"
                            readonly
                            required>
                    </div>

                    {{-- KENDALA --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kendala Distribusi</label>
                        <select name="kendala"
                                id="kendala"
                                class="form-select rounded-3">
                            <option value="Tidak Ada">Tidak Ada</option>
                            <option value="Terlambat">Terlambat</option>
                            <option value="Porsi Kurang">Porsi Kurang</option>
                        </select>
                    </div>

                    {{-- RATING --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Rating Kepuasan <span id="ratingValue" class="fw-bold text-success">5.0</span> ⭐
                        </label>
                        {{-- STAR VISUAL --}}
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="star-rating">
                                <div class="stars-back">★★★★★</div>
                                <div class="stars-front" id="starsFront">★★★★★</div>
                            </div>
                            <span class="text-muted small">/ 5</span>
                        </div>

                        <input type="range"
                            name="rating"
                            id="rating"
                            min="1"
                            max="5"
                            step="0.1"
                            value="5"
                            class="form-range">
                    </div>

                    {{-- CATATAN --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan Gizi</label>
                        <textarea name="catatan"
                                id="catatan"
                                class="form-control rounded-3"
                                rows="3"></textarea>
                    </div>

                    {{-- FOTO --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">Upload Foto Menu</label>
                        <div class="upload-box" id="uploadBox">
                            <input type="file" id="fotoLaporan" name="foto" accept="image/*" hidden>
                            <div class="upload-content text-center">
                                <i class="bi bi-cloud-arrow-up fs-1"></i>
                                <p class="mb-1 fw-semibold">Drag atau klik untuk upload</p>
                                <small class="text-muted">Format: JPG, PNG, JPEG (maks 5MB)</small>
                            </div>
                            <img id="previewImage" class="img-preview d-none">
                        </div>
                    </div>

                    {{-- BUTTON --}}
                    <div class="col-12 d-flex justify-content-center gap-3 mt-4">
                        <button type="button"
                                id="btnSubmit"
                                class="btn text-white px-5 rounded-pill"
                                style="background:#1f5132;">
                            Kirim Laporan
                        </button>
                    </div>

                </div>
            </form>


        </div>
    </div>
</div>
@endsection
{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@push('js')
<script>
const uploadBox = document.getElementById('uploadBox');
    const fileInput = document.getElementById('fotoLaporan');
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

    const porsiPemerintah = document.getElementById('porsi_pemerintah');
    const porsiDiterima   = document.getElementById('porsi_diterima');
    const jumlahSisa      = document.getElementById('jumlah_sisa');

    porsiDiterima.addEventListener('input', function () {
        const pemerintah = parseInt(porsiPemerintah.value) || 0;
        const diterima   = parseInt(this.value) || 0;

        if (diterima > pemerintah) {
            this.value = pemerintah;
        }

        jumlahSisa.value = Math.max(pemerintah - diterima, 0);
    });

    // rating preview
    const ratingInput = document.getElementById('rating');
    const ratingValue = document.getElementById('ratingValue');
    const starsFront  = document.getElementById('starsFront');

    function updateStars(value) {
        const percent = (value / 5) * 100;
        starsFront.style.width = percent + '%';
        ratingValue.innerText = parseFloat(value).toFixed(1);
    }

    // init
    updateStars(ratingInput.value);

    ratingInput.addEventListener('input', function () {
        updateStars(this.value);
    });
$('#btnSubmit').on('click', function () {

    let formData = new FormData($('#formLaporan')[0]);

    $.ajax({
        url: "{{ route('sekolah.input_laporan.store') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#btnSubmit').prop('disabled', true).text('Menyimpan...');
        },
        success: function (res) {

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                // Optional: Redirect or reset form
                location.reload();
            });

            $('#formLaporan')[0].reset();
        },
        error: function (xhr) {
            let msg = 'Terjadi kesalahan';

            if (xhr.responseJSON?.errors) {
                msg = Object.values(xhr.responseJSON.errors)[0][0];
            }

            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: msg
            });
        },
        complete: function () {
            $('#btnSubmit').prop('disabled', false).text('Kirim Laporan');
        }
    });
});
</script>
@endpush
