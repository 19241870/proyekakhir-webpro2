<?php

namespace App\Http\Controllers\Pemerintah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManajemenSekolah;
use App\Models\MbgKeluhan;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahSekolah = ManajemenSekolah::count();
        $jumlahKeluhan = MbgKeluhan::count();
        return view('pemerintah.dashboard', compact('jumlahSekolah', 'jumlahKeluhan'));
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
