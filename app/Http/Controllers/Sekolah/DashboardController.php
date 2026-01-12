<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ManajemenSekolah;
use App\Models\MbgLaporanHarian;

class DashboardController extends Controller
{
    public function index()
    {
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
        return view('sekolah.dashboard', compact('jumlahLaporanBulanIni', 'jumlahRating', 'jumlahSiswaPorsi'));
    }
}