    @extends('layouts.app')

    @section('title', 'Monitoring Sekolah')
    @section('page-title', 'Monitoring Sekolah')

    @section('content')
    <div class="container-fluid py-4">

        {{-- HEADER FILTER --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3 p-4">

                <div>
                    <h5 class="fw-black mb-1" style="color:#1a4d2e;">Monitoring Sekolah</h5>
                    <small class="text-muted text-uppercase fw-bold" style="font-size:11px;">
                        Status Laporan Real-Time
                    </small>
                </div>

                <div class="d-flex gap-4">
                    <input type="text"
                        class="form-control rounded-pill px-4"
                        placeholder="Cari nama sekolah..."
                        style="max-width:240px">

                    <button class="btn btn-success rounded-pill px-4 fw-bold"
                            style="background:#1a4d2e;">
                        Filter Data
                    </button>
                </div>

            </div>
        </div>

        {{-- TABLE --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">

                    <thead class="bg-light text-uppercase text-muted"
                        style="font-size:11px;letter-spacing:1px;">
                        <tr>
                            <th class="px-4 py-3">Nama Sekolah</th>
                            <th class="px-4 py-3">Wilayah / Kecamatan</th>
                            <th class="px-4 py-3">Jam Lapor</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">

                        @php
                            $data_sekolah = [
                                ['nama' => 'SDN Karawang Barat 01', 'kec' => 'Karawang Barat', 'jam' => '08:15', 'status' => 'TERKIRIM'],
                                ['nama' => 'SDN Nagasari 02', 'kec' => 'Karawang Barat', 'jam' => '09:00', 'status' => 'TERKIRIM'],
                                ['nama' => 'SDN Karawang Wetan 04', 'kec' => 'Karawang Timur', 'jam' => '-', 'status' => 'MENUNGGU'],
                                ['nama' => 'SDN Adiarsa Timur 01', 'kec' => 'Karawang Timur', 'jam' => '07:45', 'status' => 'TERKIRIM'],
                                ['nama' => 'SDN Telukjambe 03', 'kec' => 'Telukjambe Timur', 'jam' => '-', 'status' => 'MENUNGGU'],
                            ];
                        @endphp

                        @foreach($data_sekolah as $s)
                        <tr class="border-bottom">

                            <td class="px-4 fw-semibold">{{ $s['nama'] }}</td>
                            <td class="px-4 text-muted">{{ $s['kec'] }}</td>
                            <td class="px-4 text-muted">{{ $s['jam'] }}</td>

                            <td class="px-4 text-center">
                                <span class="badge rounded-pill px-3 py-2 text-uppercase fw-bold"
                                    style="font-size:10px;
                                    {{ $s['status'] === 'TERKIRIM'
                                            ? 'background:#e6f4ea;color:#1a7f37'
                                            : 'background:#fdecea;color:#b42318' }}">
                                    {{ $s['status'] }}
                                </span>
                            </td>

                            <td class="px-4 text-end">
                                <button class="btn btn-light btn-sm rounded-pill fw-bold text-uppercase"
                                        style="font-size:10px"
                                        onclick="bukaEdit('{{ $s['nama'] }}','{{ $s['status'] }}')">
                                    Edit
                                </button>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">

                <div class="modal-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-black mb-0" style="color:#1a4d2e;">Edit Data Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase fw-bold text-muted"
                            style="font-size:11px;">Nama Sekolah</label>
                        <input type="text" id="editNama" class="form-control rounded-pill">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase fw-bold text-muted"
                            style="font-size:11px;">Status Laporan</label>
                        <select id="editStatus" class="form-select rounded-pill">
                            <option value="TERKIRIM">TERKIRIM</option>
                            <option value="MENUNGGU">MENUNGGU</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-light w-100 rounded-pill fw-bold"
                                data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button class="btn btn-dark w-100 rounded-pill fw-bold text-uppercase">
                            Simpan
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
    function bukaEdit(nama, status) {
        document.getElementById('editNama').value = nama;
        document.getElementById('editStatus').value = status;
        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    }
    </script>
    @endsection
