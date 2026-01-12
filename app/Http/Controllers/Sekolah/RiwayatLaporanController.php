<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MbgLaporanHarian;

class RiwayatLaporanController extends Controller
{
    public function index()
    {
        return view('sekolah.riwayat');
    }
    
    public function data(Request $request)
    {
        $sekolahId = Auth::user()->sekolah->id;

        $query = MbgLaporanHarian::with('menu')
            ->where('sekolah_id', $sekolahId);

        // FILTER PERIODE
        if ($request->periode) {
            switch ($request->periode) {
                case 'today':
                    $query->whereDate('tanggal', now());
                    break;

                case 'week':
                    $query->whereDate('tanggal', '>=', now()->subDays(7));
                    break;

                case 'month':
                    $query->whereMonth('tanggal', now()->month)
                        ->whereYear('tanggal', now()->year);
                    break;
            }
        }

        $laporan = $query
            ->orderBy('tanggal', 'desc')
            ->paginate(5)
            ->withQueryString(); // 🔥 PENTING

        return response()->json($laporan);
    }
}