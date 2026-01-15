<?php

namespace App\Http\Controllers\Pemerintah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManajemenSekolah;
use App\Models\MbgKeluhan;
use App\Models\MbgMenu;
use App\Models\MbgLaporanHarian;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
Carbon::setLocale('id');

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahSekolah = ManajemenSekolah::count();
        $jumlahKeluhan = MbgKeluhan::count();
         $jumlahSiswa = MbgLaporanHarian::sum('jumlah_porsi');
        $jumlahLaporanHariIni = MbgLaporanHarian::whereDate('created_at', today())->count();
        $jumlahPersen = $jumlahSekolah > 0 ? round(($jumlahLaporanHariIni / $jumlahSekolah) * 100) : 0;
         // ===============================
        // LINE CHART – DISTRIBUSI HARIAN
        // ===============================
        $distribusi = MbgLaporanHarian::select(
                DB::raw('DATE(tanggal) as hari'),
                DB::raw('SUM(jumlah_porsi) as total_porsi')
            )
            ->whereBetween('tanggal', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->groupBy('hari')
            ->orderBy('hari')
            ->get();

        $lineLabels = $distribusi->map(function ($d) {
            return Carbon::parse($d->hari)->translatedFormat('l');
        });

        $lineData = $distribusi->pluck('total_porsi');

        // ===============================
        // DONUT – STATUS LAPORAN
        // ===============================
        $totalLaporan = MbgLaporanHarian::count();

        $terverifikasi = MbgLaporanHarian::where('status', 'TERVERIFIKASI')->count();

        $belum = $totalLaporan - $terverifikasi;

        $donutData = [
            'lengkap' => $terverifikasi,
            'belum'   => $belum
        ];
        return view('pemerintah.dashboard', compact('jumlahSekolah', 'jumlahKeluhan', 'jumlahSiswa', 'jumlahLaporanHariIni', 'jumlahPersen', 'lineLabels',
        'lineData',
        'donutData'));
    }

     public function monitoring()
    {
        return view('pemerintah.monitoring');
    }

    public function laporan()
    {
        return view('pemerintah.laporan');
    }

    public function keluhan()
    {
        return view('pemerintah.keluhan');
    }

    public function menu()
    {
        return view('pemerintah.menu');
    }
}
