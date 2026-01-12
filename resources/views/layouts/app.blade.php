<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard MBG')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    @stack('css')
</head>
<body>

<!-- OVERLAY -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5 class="fw-bold text-white mb-0">MBG</h5>
            <small>Pemerintah</small>
        </div>

        <ul class="nav flex-column mt-4">

        {{-- ================= ADMIN PEMERINTAH ================= --}}
        @if(auth()->user()->role === 'admin')

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pemerintah.dashboard') ? 'active' : '' }}"
                   href="{{ route('pemerintah.dashboard') }}">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pemerintah.monitoring') ? 'active' : '' }}"
                   href="{{ route('pemerintah.monitoring') }}">
                    <i class="bi bi-geo-alt"></i> Monitoring Sekolah
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pemerintah.laporan') ? 'active' : '' }}"
                   href="{{ route('pemerintah.laporan') }}">
                    <i class="bi bi-file-earmark-text"></i> Laporan Harian
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pemerintah.keluhan') ? 'active' : '' }}"
                   href="{{ route('pemerintah.keluhan') }}">
                    <i class="bi bi-exclamation-triangle"></i> Keluhan
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pemerintah.menu') ? 'active' : '' }}"
                   href="{{ route('pemerintah.menu') }}">
                    <i class="bi bi-list"></i> Kelola Menu
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pemerintah.sekolah') ? 'active' : '' }}"
                   href="{{ route('pemerintah.sekolah') }}">
                    <i class="bi bi-building"></i> Manajemen Sekolah
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pemerintah.pengguna') ? 'active' : '' }}"
                   href="{{ route('pemerintah.pengguna') }}">
                    <i class="bi bi-people"></i> Pengguna
                </a>
            </li>

        {{-- ================= SEKOLAH ================= --}}
        @elseif(auth()->user()->role === 'sekolah')

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sekolah.dashboard') ? 'active' : '' }}"
                   href="{{ route('sekolah.dashboard') }}">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sekolah.input_laporan') ? 'active' : '' }}"
                   href="{{ route('sekolah.input_laporan') }}">
                    <i class="bi bi-file-earmark-plus"></i> Laporan Harian
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sekolah.riwayat') ? 'active' : '' }}"
                   href="{{ route('sekolah.riwayat') }}">
                    <i class="bi bi-clock-history"></i> Riwayat Laporan
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sekolah.menu') ? 'active' : '' }}"
                   href="{{ route('sekolah.menu') }}">
                    <i class="bi bi-calendar-week"></i> Menu Mingguan
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sekolah.keluhan') ? 'active' : '' }}"
                   href="{{ route('sekolah.keluhan') }}">
                    <i class="bi bi-chat-dots"></i> Keluhan & Saran
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sekolah.profil') ? 'active' : '' }}"
                   href="{{ route('sekolah.profil') }}">
                    <i class="bi bi-person-badge"></i> Profil Sekolah
                </a>
            </li>

        @endif
    </ul>


        <div class="sidebar-footer">
            @if(auth()->user()->role === 'admin')
                <small>Admin Pemerintah</small> <br>
            @else
                <small>{{ auth()->user()->sekolah->nama_sekolah ?? 'Sekolah' }}</small> <br>
            @endif

            <span class="online">● Online</span>
            <a href="{{ route('logout') }}" class="logout mt-3">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="content" id="content">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-white d-lg-none" id="toggleSidebar">
                    <i class="bi bi-list fs-4"></i>
                </button>

                <button class="btn btn-white d-none d-lg-flex" id="toggleSidebarDesktop">
                    <i class="bi bi-list fs-4"></i>
                </button>

                <h5 class="fw-bold mb-0">@yield('page-title')</h5>
            </div>

            <div class="d-flex align-items-center gap-3">

                <!-- NOTIFIKASI -->
                <div class="dropdown">
                    <i class="bi bi-bell fs-5 position-relative cursor-pointer"
                    id="notifBell"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                        <span id="notifBadge"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                            0
                        </span>
                    </i>

                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2"
                        style="width:320px"
                        id="notifDropdown">

                        <div class="px-3 py-2 border-bottom fw-bold text-success">
                            Notifikasi Terbaru
                        </div>

                        <div id="notifList" class="py-2">
                            <div class="text-center text-muted small py-3">
                                Memuat notifikasi...
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Garis vertikal -->
                <div class="vr"></div>
                <!-- INFO USER -->
                <div class="d-flex align-items-center gap-2">

                    <!-- AVATAR -->
                    <div class="rounded-circle bg-success text-white fw-bold d-flex align-items-center justify-content-center"
                        style="width:38px;height:38px;background:#1a4d2e;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <!-- NAMA + SEKOLAH -->
                    <div class="d-flex flex-column lh-sm">
                        <span class="fw-semibold" style="font-size:14px;">
                            {{ auth()->user()->name }}
                        </span>

                        @if(auth()->user()->role === 'sekolah')
                            <small class="text-muted" style="font-size:11px;">
                                {{ auth()->user()->sekolah->nama_sekolah ?? 'Sekolah' }}
                            </small>
                        @else
                            <small class="text-muted" style="font-size:11px;">
                                Admin Pemerintah
                            </small>
                        @endif
                    </div>

                </div>
            </div>
        </header>


        <!-- PAGE BODY -->
        <div class="page-body">
            @yield('content')
        </div>

        <footer class="text-center small text-muted mt-4">
            © {{ date('Y') }} MBG – Sistem Monitoring Gizi
        </footer>

    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
function loadNotifikasi() {
    $.get("{{ route('notifikasi.index') }}", function (res) {

        let html = '';

        if (res.count === 0) {
            html = `
                <div class="text-center text-muted small py-3">
                    Tidak ada notifikasi
                </div>
            `;
            $('#notifBadge').addClass('d-none').text(0);
        } else {
            $('#notifBadge')
                .removeClass('d-none')
                .text(res.count);
        }

        res.data.forEach(n => {
            let bgUnread = n.is_read == 0 ? 'bg-light' : '';

            html += `
                <div class="dropdown-item rounded-3 py-2 px-3 small notif-item ${bgUnread}"
                     data-id="${n.id}"
                     data-link="${n.link}">
                    <div class="d-flex gap-2">
                        <div class="fs-5">${n.icon}</div>
                        <div class="flex-grow-1 notification-content">
                            <div class="fw-bold">${n.judul}</div>
                            <div class="text-muted notification-message">${n.pesan}</div>
                            ${n.sekolah ? `<div class="text-success fw-bold">${n.sekolah}</div>` : ''}
                            <small class="text-muted">${n.waktu}</small>
                        </div>
                    </div>
                </div>
            `;
        });

        $('#notifList').html(html);
    });
}

loadNotifikasi();
setInterval(loadNotifikasi, 5000); // realtime polling

$(document).on('click', '.notif-item', function () {
    let id   = $(this).data('id');
    let link = $(this).data('link');
    
    $.post("{{ route('notifikasi.read.one') }}", {
        _token: '{{ csrf_token() }}',
        id: id
    }, function () {
        loadNotifikasi(); // refresh badge & list
        if (link) window.location.href = link;
    });
});
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const content = document.getElementById('content');

    document.getElementById('toggleSidebar').onclick = () => {
        sidebar.classList.add('show');
        overlay.classList.add('active');
    };

    document.getElementById('toggleSidebarDesktop').onclick = () => {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('expanded');
    };

    overlay.onclick = () => {
        sidebar.classList.remove('show');
        overlay.classList.remove('active');
    };

</script>

@stack('js')
</body>
</html>
