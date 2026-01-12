@extends('layouts.app')

@section('title', 'Pengaturan Pengguna')
@section('page-title', 'Pengaturan Pengguna')

@section('content')

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Pengguna</h4>
        <small class="text-muted">Kelola akun pengguna aplikasi MBG</small>
    </div>

    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUser">
        <i class="bi bi-plus-lg"></i> Tambah Pengguna
    </button>
</div>

<!-- TABLE -->
<div class="card chart-card">
    <div class="table-responsive">
        <table class="table align-middle table-hover" id="tbl_user">
            <thead class="table-dark">
                <tr>
                    <th width="5%">#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th class="text-center" width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $i => $user)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge
                            {{ $user->role === 'sekolah' ? 'bg-success' : 'bg-info' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning"
                            onclick="editUser({{ $user->id }})">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <button class="btn btn-sm btn-danger"
                            onclick="hapusUser({{ $user->id }})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Data pengguna belum tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH / EDIT USER -->
<div class="modal fade" id="modalUser" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalUserTitle">
                    Tambah Pengguna
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="formUser">
                    @csrf
                    <input type="hidden" id="user_id">

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Kosongkan jika tidak diubah">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin Pemerintah</option>
                            <option value="sekolah">Sekolah</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-success" id="btnSimpanUser">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
$(document).ready(function() {
    $('#tbl_user').DataTable({
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
            { orderable: false, targets: [1, 5] } // Foto & Aksi
        ]
    });
});
$('#btnSimpanUser').on('click', function () {
    let id = $('#user_id').val()
    let form = $('#formUser')[0];
    let formData = new FormData(form);
    let url = id
        ? "{{ route('pemerintah.pengguna.update', ':id') }}".replace(':id', id)
        : "{{ route('pemerintah.pengguna.store') }}";

    if (id) {
        formData.append('_method', 'PUT'); // 🔥 UPDATE
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
                $('#modalUser').modal('hide');
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

function editUser(id) {
    // reset form dulu
    $('#formUser')[0].reset();
    $('#user_id').val('');

    $.ajax({
        url: `/pemerintah/pengguna/${id}/edit`,
        type: 'GET',
        success: function (res) {

            // set title
            $('#modalUserTitle').text('Edit Pengguna');

            // set ID
            $('#user_id').val(res.id);

            // isi form
            $('input[name="name"]').val(res.name);
            $('input[name="email"]').val(res.email);
            $('select[name="role"]').val(res.role);

            $('input[name="password"]').val('');

            // tampilkan modal
            $('#modalUser').modal('show');
        },
        error: function () {
            alert('Gagal mengambil data pengguna');
        }
    });
}

function hapusUser(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus pengguna ini?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('pemerintah.pengguna.destroy', ':id') }}".replace(':id', id),
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: 'DELETE'
                },
                beforeSend: function () {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu',
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
                        text: 'Terjadi kesalahan saat menghapus pengguna'
                    });
                }
            });
        }
    });
}
</script>
@endpush
