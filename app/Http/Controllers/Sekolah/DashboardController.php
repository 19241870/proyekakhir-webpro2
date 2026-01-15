<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ManajemenSekolah;
use App\Models\MbgLaporanHarian;
use App\Models\MbgMenu;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
Carbon::setLocale('id');

class DashboardController extends Controller
{
    public function index()
    {
        $sekolahId = Auth::user()->sekolah->id;

        // Hitung jumlah laporan bulan ini
        $jumlahLaporanBulanIni = MbgLaporanHarian::whereHas('sekolah', function ($query) {
            $query->where('id', Auth::user()->sekolah->id);
        })->whereMonth('created_at', now()->month)
          ->whereYear('created_at', now()->year)
          ->count();
        $jumlahRating = MbgLaporanHarian::whereHas('sekolah', function ($query) {
            $query->where('id', Auth::user()->sekolah->id);
        })->whereMonth('created_at', now()->month)
          ->whereYear('created_at', now()->year)
          ->avg('rating');
        $jumlahSiswaPorsi = MbgLaporanHarian::whereHas('sekolah', function ($query) {
            $query->where('id', Auth::user()->sekolah->id);
        })->whereMonth('created_at', now()->month)
          ->whereYear('created_at', now()->year)
          ->sum('jumlah_porsi');


        // ===============================
        // BAR CHART – LAPORAN PER MINGGU
        // ===============================
        $laporanMingguan = MbgLaporanHarian::select(
                DB::raw('DATE(tanggal) as hari'),
                DB::raw('SUM(jumlah_porsi) as total')
            )
            ->where('sekolah_id', $sekolahId)
            ->whereBetween('tanggal', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->groupBy('hari')
            ->orderBy('hari')
            ->get();

        $barLabels = $laporanMingguan->map(fn ($d) =>
            Carbon::parse($d->hari)->translatedFormat('l')
        );

        $barData = $laporanMingguan->pluck('total');

        // ===============================
        // PIE CHART – JENIS MENU
        // ===============================
        $menus = MbgMenu::where('sekolah_id', $sekolahId)->pluck('nama_menu');

        $menuKategori = [
            'Ayam'   => 0,
            'Daging' => 0,
            'Ikan'   => 0,
            'Telur'  => 0,
        ];

        foreach ($menus as $menuString) {

          // Pecah: "Nasi + Ayam + Sayur Sop"
          $items = array_map(
              'trim',
              explode('+', strtolower($menuString))
          );

          foreach ($items as $item) {

              if (str_contains($item, 'ayam')) {
                  $menuKategori['Ayam']++;
              }

              if (str_contains($item, 'daging')) {
                  $menuKategori['Daging']++;
              }

              if (str_contains($item, 'ikan')) {
                  $menuKategori['Ikan']++;
              }

              if (str_contains($item, 'telur')) {
                  $menuKategori['Telur']++;
              }
          }
        }
        return view('sekolah.dashboard', compact('jumlahLaporanBulanIni', 'jumlahRating', 'jumlahSiswaPorsi', 'barLabels',
        'barData',
        'menuKategori'));
    }
}
