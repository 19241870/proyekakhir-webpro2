@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-success mb-0">Profil Sekolah</h3>
            <small class="text-muted">Profil Sekolah MBG Karawang</small>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-light rounded-circle shadow-sm">
                🔔
            </button>

            <div class="d-flex align-items-center gap-3 border-start ps-3">
                <div class="text-end">
                    <div class="fw-bold text-success small">Pihak Sekolah</div>
                    <div class="text-muted small">{{ $sekolah->nama_sekolah }}</div>
                </div>
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                     style="width:45px;height:45px;">
                    👤
                </div>
            </div>
        </div>
    </div>

    {{-- CARD PROFIL --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-lg-5">

            <h4 class="fw-bold text-success mb-4 text-uppercase">
                {{ $sekolah->nama_sekolah }}
            </h4>

            <form id="formProfil">
                @csrf
                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Sekolah</label>
                        <input type="text" class="form-control rounded-3"
                               name="nama_sekolah"
                               value="{{ $sekolah->nama_sekolah }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NPSN</label>
                        <input type="text" class="form-control rounded-3"
                               name="npsn"
                               value="{{ $sekolah->npsn }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat Sekolah</label>
                        <textarea class="form-control rounded-3"
                                  name="alamat"
                                  rows="3">{{ $sekolah->alamat }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jumlah Siswa</label>
                        <input type="number" class="form-control rounded-3"
                               name="jumlah_siswa"
                               value="{{ $sekolah->jumlah_siswa }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kepala Sekolah</label>
                        <input type="text" class="form-control rounded-3"
                               name="kepala_sekolah"
                               value="{{ $sekolah->kepala_sekolah }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Telepon Sekolah</label>
                        <input type="text" class="form-control rounded-3"
                               name="telepon"
                               value="{{ $sekolah->telepon }}">
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="button" id="btnSimpan"
                                class="btn btn-success px-5 rounded-pill">
                            Simpan Perubahan
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

</div>
@endsection
@push('js')
<script>
    $('#btnSimpan').on('click', function () {

    let formData = $('#formProfil').serialize();

    $.ajax({
        url: "{{ route('sekolah.profil.update') }}",
        type: "POST",
        data: formData + '&_token={{ csrf_token() }}',
        success: function (res) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message,
                confirmButtonColor: '#198754'
            });
        },
        error: function () {
            Swal.fire('Error', 'Gagal menyimpan data', 'error');
        }
    });
});
</script>
@endpush