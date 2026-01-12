<?php

namespace App\Http\Controllers\Pemerintah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MbgKeluhan;
use App\Models\Notification;

class KeluhanController extends Controller
{
    public function index()
    {
        $jumlahKeluhan = MbgKeluhan::count();
        return view('pemerintah.keluhan', compact('jumlahKeluhan'));
    }

    public function data()
    {
        $keluhans = MbgKeluhan::with('sekolah')
            ->latest()
            ->get()
            ->map(function ($k) {
                return [
                    'id'       => $k->id,
                    'sekolah'  => $k->sekolah->nama_sekolah ?? '-',
                    'kategori' => $k->kategori,
                    'pesan'    => $k->deskripsi,
                    'status'   => $k->status,
                    'tanggal'  => $k->tanggal->format('d M Y'),
                    'icon'     => $k->status === 'Selesai' ? '✓' : '⚠️',
                ];
            });

        return response()->json($keluhans);
    }

    public function show($id)
    {
        $keluhan = MbgKeluhan::with('sekolah')->findOrFail($id);

        return response()->json([
            'id'            => $keluhan->id,
            'nama_sekolah'  => $keluhan->sekolah->nama_sekolah,
            'kategori'      => $keluhan->kategori,
            'deskripsi'   => $keluhan->deskripsi,
            'foto'          => $keluhan->foto,
            'status'        => $keluhan->status,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diproses,Selesai'
        ]);

        // Ambil keluhan + sekolah pemilik
        $keluhan = MbgKeluhan::with('sekolah')->findOrFail($id);

        // Update status
        $keluhan->update([
            'status' => $request->status
        ]);

        // ==========================
        // NOTIFIKASI KE SEKOLAH
        // ==========================
        Notification::create([
            'user_id' => $keluhan->sekolah_id, // PENTING
            'role'    => 'sekolah',
            'type'    => 'keluhan',
            'title'   => 'Update Status Keluhan',
            'message' => 'Keluhan Anda sekarang berstatus: ' . $request->status,
            'link'    => url('/sekolah/keluhan'),
            'is_read' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status keluhan berhasil diperbarui'
        ]);
    }
}   
