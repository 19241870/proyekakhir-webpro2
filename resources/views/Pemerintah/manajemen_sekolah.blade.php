@extends('layouts.app')

@section('title', 'Dashboard Pemerintah')
@section('page-title', 'Dashboard Monitoring')

@section('content')

<!-- HEADER -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-0">Manajemen Sekolah</h4>
                        <small class="text-muted">Kelola data sekolah penerima MBG</small>
                    </div>

                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalSekolah">
                        <i class="bi bi-plus-lg"></i> Tambah Sekolah
                    </button>
                </div>

                <!-- TABLE CARD -->
                <div class="card chart-card">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover" id="tbl_sekolah">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nama Sekolah</th>
                                    <th>NPSN</th>
                                    <th>Jenjang</th>
                                    <th>Status</th>
                                    <th>Kecamatan</th>
                                    <th>Porsi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sekolah as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>

                                    <td>
                                        <img src="{{ $row->foto
                                            ? asset('storage/'.$row->foto)
                                            : 'https://via.placeholder.com/50' }}"
                                            class="rounded"
                                            width="50">
                                    </td>

                                    <td class="fw-semibold">{{ $row->nama_sekolah }}</td>

                                    <td>{{ $row->npsn }}</td>

                                    <td>
                                        <span class="badge
                                            {{ $row->jenjang == 'SMK' ? 'bg-primary' : 'bg-info' }}">
                                            {{ $row->jenjang }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge
                                            {{ $row->status == 'Negeri' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $row->status }}
                                        </span>
                                    </td>

                                    <td>{{ $row->kecamatan }}</td>

                                    <td class="fw-bold">{{ $row->jumlah_porsi }}</td>

                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning"
                                            onclick="editSekolah({{ $row->id }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <button class="btn btn-sm btn-danger"
                                            onclick="hapusSekolah({{ $row->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        Data sekolah belum tersedia
                                    </td>
                                </tr>
                                @endforelse
                                </tbody>
                        </table>
                    </div>
                </div>

    <!-- MODAL TAMBAH / EDIT SEKOLAH -->
    <div class="modal fade" id="modalSekolah" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Sekolah</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="formSekolah" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- UPLOAD FOTO -->
                        <input type="hidden" name="id" id="sekolah_id">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Foto Sekolah</label>
                            <div class="upload-box" id="uploadBox">
                                <input type="file" id="fotoSekolah" name="foto" accept="image/*" hidden>
                                <div class="upload-content text-center">
                                    <i class="bi bi-cloud-arrow-up fs-1"></i>
                                    <p class="mb-1 fw-semibold">Drag & Drop Foto</p>
                                    <small class="text-muted">atau klik untuk upload</small>
                                </div>
                                <img id="previewImage" class="img-preview d-none">
                            </div>
                        </div>

                        <!-- FORM INPUT -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Akun Sekolah</label>
                                <select name="user_id" id="user_id" class="form-select" required>
                                    <option value="">-- Pilih Akun Sekolah --</option>
                                    @foreach($usersSekolah as $u)
                                        <option value="{{ $u->id }}">
                                            {{ $u->name }} ({{ $u->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Sekolah</label>
                                <input type="text" name="nama_sekolah" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">NPSN</label>
                                <input type="text" name="npsn" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jenjang</label>
                                <select name="jenjang" class="form-select">
                                    <option value="SMK">SMK</option>
                                    <option value="SMA">SMA</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="Negeri">Negeri</option>
                                    <option value="Swasta">Swasta</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jumlah Porsi</label>
                                <input type="number" name="jumlah_porsi" class="form-control">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" rows="2"></textarea>
                            </div>
                        </div>


                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="btnSimpanSekolah">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script>
 const uploadBox = document.getElementById('uploadBox');
    const fileInput = document.getElementById('fotoSekolah');
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
$(document).ready(function() {
    $('#tbl_sekolah').DataTable({
        pageLength: 10,
        lengthChange: true,
        ordering: true,
        responsive: true,
        language: {
            search: "Cari:",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data",
            paginate: {
                next: "›",
                previous: "‹"
            }
        },
        columnDefs: [
            { orderable: false, targets: [1, 8] } // Foto & Aksi
        ]
    });
});

function editSekolah(id) {

    // reset form dulu
    $('#formSekolah')[0].reset();
    $('#sekolah_id').val('');

    $.ajax({
        url: `/pemerintah/manajemen-sekolah/${id}/edit`,
        type: 'GET',
        success: function (res) {

            // set title
            $('.modal-title').text('Edit Sekolah');

            // set ID
            $('#sekolah_id').val(res.id);

            // isi form
            $('input[name="nama_sekolah"]').val(res.nama_sekolah);
            $('input[name="npsn"]').val(res.npsn);
            $('select[name="user_id"]').val(res.user_id);
            $('select[name="jenjang"]').val(res.jenjang);
            $('select[name="status"]').val(res.status);
            $('input[name="kecamatan"]').val(res.kecamatan);
            $('input[name="jumlah_porsi"]').val(res.jumlah_porsi);
            $('textarea[name="alamat"]').val(res.alamat);

            // preview foto
            if (res.foto) {
                $('#previewImage')
                    .attr('src', `/storage/${res.foto}`)
                    .removeClass('d-none');

                $('.upload-content').hide();
            } else {
                $('#previewImage').addClass('d-none');
                $('.upload-content').show();
            }

            // tampilkan modal
            $('#modalSekolah').modal('show');
        },
        error: function () {
            alert('Gagal mengambil data sekolah');
        }
    });
}

// hapus sekolah
function hapusSekolah(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Data sekolah akan dihapus secara permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('pemerintah.sekolah.destroy', ':id') }}".replace(':id', id),
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                beforeSend: function () {
                    Swal.fire({
                        title: 'Menghapus...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });
                },
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menghapus data sekolah.'
                    });
                }
            });
        }
    });
}

$('#btnSimpanSekolah').on('click', function () {
    let id = $('#sekolah_id').val();
    let form = $('#formSekolah')[0];
    let formData = new FormData(form);
    // tentukan url & method
    let url = id
        ? "{{ route('pemerintah.sekolah.update', ':id') }}".replace(':id', id)
        : "{{ route('pemerintah.sekolah.store') }}";
    if (id) {
        formData.append('_method', 'PUT');
    }

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            Swal.fire({
                title: 'Menyimpan...',
                text: 'Mohon tunggu',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function (res) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                $('#modalSekolah').modal('hide');
                location.reload();
            });
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
        }
    });
});
</script>


@endpush
