<?php

namespace App\Http\Controllers\Pemerintah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManajemenSekolah;
use App\Models\MbgLaporanHarian;
use App\Models\MbgMenu;
use App\Models\Notification;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    public function index()
    {
        $tanggal = Carbon::today()->toDateString();

        $data = MbgLaporanHarian::with('sekolah')
            ->where('tanggal', $tanggal)
            ->get();
        return view('pemerintah.monitoring', compact('data'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mbg_laporan_harian,id',
            'status' => 'required|in:BELUM TERVERIFIKASI,TERVERIFIKASI'
        ]);

        $laporan = MbgLaporanHarian::where('id', $request->id)->first();

        MbgLaporanHarian::where('id', $request->id)
            ->update([
                'status' => $request->status
            ]);

        Notification::create([
            'user_id' => $laporan->sekolah_id, // PENTING
            'role'    => 'sekolah',
            'type'    => 'laporan',
            'title'   => 'Update Status Laporan',
            'message' => 'Laporan Anda sekarang berstatus: ' . $request->status,
            'link'    => url('/sekolah/riwayat'),
            'is_read' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status laporan berhasil diperbarui'
        ]);
    }

}