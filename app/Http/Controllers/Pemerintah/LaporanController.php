<?php

namespace App\Http\Controllers\Pemerintah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MbgKeluhan;
use App\Models\ManajemenSekolah;
use App\Models\MbgLaporanHarian;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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
        $jumlahMenu = ManajemenSekolah::sum('jumlah_porsi');
        $totalSekolah = ManajemenSekolah::count();

        $sekolahSudahDistribusi = MbgLaporanHarian::whereDate('tanggal', today())
            ->whereIn('status', ['BELUM TERVERIFIKASI', 'TERVERIFIKASI'])
            ->distinct('sekolah_id')
            ->count('sekolah_id');

        $pemerataan = $totalSekolah > 0
            ? round(($sekolahSudahDistribusi / $totalSekolah) * 100)
            : 0;
        return view('pemerintah.laporan', compact('jumlahKeluhan', 'labels', 'data', 'jumlahMenu', 'pemerataan'));
    }

    public function filter(Request $request)
    {
        $periode = $request->periode ?? 'harian';
        $from = $request->from;
        $to   = $request->to;

        $keluhanQuery = MbgKeluhan::query();

        // Filter tanggal custom
        if ($from && $to) {
            $keluhanQuery->whereBetween('created_at', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        }

        // Filter periode
        if ($periode === 'harian') {
            $keluhanQuery->whereDate('created_at', Carbon::today());
        }

        if ($periode === 'mingguan') {
            $keluhanQuery->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        }

        if ($periode === 'bulanan') {
            $keluhanQuery->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year);
        }

        $jumlahKeluhan = $keluhanQuery->count();

        $keluhanPerKategori = $keluhanQuery
            ->select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->orderBy('kategori')
            ->get();

        $labels = $keluhanPerKategori->pluck('kategori');
        $data   = $keluhanPerKategori->pluck('total');

        $menuQuery = ManajemenSekolah::query();

        if ($from && $to) {
            $menuQuery->whereBetween('created_at', [
                Carbon::parse($from),
                Carbon::parse($to)
            ]);
        }

        $jumlahMenu = $menuQuery->sum('jumlah_porsi');

        $totalSekolah = ManajemenSekolah::count();

        $sekolahSudahDistribusi = MbgLaporanHarian::whereDate('tanggal', today())
            ->whereIn('status', ['BELUM TERVERIFIKASI', 'TERVERIFIKASI'])
            ->distinct('sekolah_id')
            ->count('sekolah_id');

        $pemerataan = $totalSekolah > 0
            ? round(($sekolahSudahDistribusi / $totalSekolah) * 100)
            : 0;

        return response()->json([
            'jumlahKeluhan' => $jumlahKeluhan,
            'jumlahMenu'    => $jumlahMenu,
            'pemerataan'    => $pemerataan,
            'labels'        => $labels,
            'data'          => $data,
        ]);
    }

    public function exportPdf(Request $request)
    {
        // Filter logic (SAMAKAN dengan filter ajax)
        $from = $request->from;
        $to   = $request->to;
        $periode = $request->periode;

        $keluhan = MbgKeluhan::with('sekolah')
            ->when($from && $to, function ($q) use ($from, $to) {
                $q->whereBetween('tanggal', [$from, $to]);
            })
            ->get();

        $jumlahKeluhan = $keluhan->count();
        $jumlahMenu = ManajemenSekolah::sum('jumlah_porsi');

        $totalSekolah = ManajemenSekolah::count();
        $sekolahDistribusi = MbgLaporanHarian::distinct('sekolah_id')->count('sekolah_id');

        $pemerataan = $totalSekolah > 0
            ? round(($sekolahDistribusi / $totalSekolah) * 100)
            : 0;

        $pdf = Pdf::loadView('pemerintah.laporan_pdf', compact(
            'keluhan',
            'jumlahKeluhan',
            'jumlahMenu',
            'pemerataan',
            'from',
            'to'
        ))->setPaper('A4', 'portrait');

        return $pdf->stream('laporan-pemerintah.pdf');
    }

}
