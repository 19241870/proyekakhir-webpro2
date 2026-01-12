<?php

namespace App\Http\Controllers\Pemerintah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MbgKeluhan;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $jumlahKeluhan = MbgKeluhan::count();
        $keluhanPerKategori = DB::table('mbg_keluhan')
            ->select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->orderBy('kategori')
            ->get();

        // Pisahkan jadi array untuk Chart.js
        $labels = $keluhanPerKategori->pluck('kategori');
        $data   = $keluhanPerKategori->pluck('total');
        return view('pemerintah.laporan', compact('jumlahKeluhan', 'labels', 'data'));
    }
}
