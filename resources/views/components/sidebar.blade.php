@php
    $isPemerintah = Request::is('pemerintah*');
    $activeBtn = "bg-black text-white shadow-md scale-105";
    $inactiveBtn = "bg-white text-black hover:bg-gray-100 hover:translate-x-1";
    $baseStyle = "flex items-center justify-center px-6 py-3 rounded-full font-black transition-all text-[13px] mb-3 decoration-none";
@endphp

<aside class="w-72 bg-[#1a4d2e] h-screen flex flex-col p-6 fixed left-0 top-0 text-white z-50 shadow-2xl">
    <div class="mb-10 mt-4 text-center">
        <h1 class="text-xl font-black tracking-tighter italic uppercase">MBG KARAWANG</h1>
        <div class="h-[5px] w-10 bg-green-400 mx-auto mt-2 rounded-full"></div>
    </div>

    <nav class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
        @if($isPemerintah)
            <a href="{{ route('pemerintah.dashboard') }}" class="{{ $baseStyle }} {{ Route::is('pemerintah.dashboard') ? $activeBtn : $inactiveBtn }}">Dashboard</a>
            <a href="{{ route('pemerintah.monitoring') }}" class="{{ $baseStyle }} {{ Route::is('pemerintah.monitoring') ? $activeBtn : $inactiveBtn }}">Monitoring Sekolah</a>
            <a href="{{ route('pemerintah.laporan') }}" class="{{ $baseStyle }} {{ Route::is('pemerintah.laporan') ? $activeBtn : $inactiveBtn }}">Laporan Harian</a>
            <a href="{{ route('pemerintah.keluhan') }}" class="{{ $baseStyle }} {{ Route::is('pemerintah.keluhan') ? $activeBtn : $inactiveBtn }}">Keluhan</a>
            <a href="{{ route('pemerintah.menu') }}" class="{{ $baseStyle }} {{ Route::is('pemerintah.menu') ? $activeBtn : $inactiveBtn }}">Kelola Menu</a>
            <a href="{{ route('pemerintah.sekolah') }}" class="{{ $baseStyle }} {{ Route::is('pemerintah.sekolah') ? $activeBtn : $inactiveBtn }}">Manajemen Sekolah</a>
        @else
            <a href="{{ route('sekolah.dashboard') }}" class="{{ $baseStyle }} {{ Route::is('sekolah.dashboard') ? $activeBtn : $inactiveBtn }}">Beranda</a>
            <a href="{{ route('sekolah.input') }}" class="{{ $baseStyle }} {{ Route::is('sekolah.input') ? $activeBtn : $inactiveBtn }}">Lapor Harian</a>
            <a href="{{ route('sekolah.riwayat') }}" class="{{ $baseStyle }} {{ Route::is('sekolah.riwayat') ? $activeBtn : $inactiveBtn }}">Riwayat Laporan</a>
            <a href="{{ route('sekolah.keluhan') }}" class="{{ $baseStyle }} {{ Route::is('sekolah.keluhan') ? $activeBtn : $inactiveBtn }}">Keluhan & Saran</a>
            <a href="{{ route('sekolah.menu') }}" class="{{ $baseStyle }} {{ Route::is('sekolah.menu') ? $activeBtn : $inactiveBtn }}">Menu Makanan</a>
            <a href="{{ route('sekolah.profil') }}" class="{{ $baseStyle }} {{ Route::is('sekolah.profil') ? $activeBtn : $inactiveBtn }}">Profil Sekolah</a>
        @endif
    </nav>

    <div class="mt-auto pt-6 border-t border-white/10">
        <div class="px-2 mb-4">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ $isPemerintah ? 'Admin Pemerintah' : 'User Sekolah' }}</p>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse shadow-[0_0_8px_#4ade80]"></div>
                <span class="text-[10px] text-green-400 font-black uppercase tracking-tighter">Sistem Online</span>
            </div>
        </div>
        <a href="{{ route('landing') }}" class="block w-full text-center bg-white text-black py-3 rounded-2xl font-black text-xs hover:bg-red-500 hover:text-white transition-all shadow-lg uppercase decoration-none">Keluar</a>
    </div>
</aside>