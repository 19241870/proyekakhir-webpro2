<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MbgKeluhan;
use App\Models\Notification;

class KeluhanController extends Controller
{
    public function index()
    {
        $sekolah = Auth::user()->sekolah;
        $keluhan = MbgKeluhan::where('sekolah_id', auth()->user()->sekolah->id)
            ->latest()
            ->get();
        return view('sekolah.keluhan', compact('sekolah', 'keluhan'));
    }

    public function store(Request $request)
    {
        $sekolah = Auth::user()->sekolah;

        $request->validate([
            'kategori'  => 'required',
            'deskripsi' => 'required',
            'tanggal'    => 'required|date',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('keluhan', 'public');
        }

        MbgKeluhan::create([
            'sekolah_id'=> $sekolah->id,
            'kategori'  => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'foto'      => $fotoPath,
            'status'    => 'Belum Diproses',
            'tanggal'   => $request->tanggal,
        ]);

        // =====================
        // NOTIFIKASI KE ADMIN
        // =====================
        Notification::create([
            'user_id' => null, // admin pemerintah (global)
            'role'    => 'admin',
            'type'    => 'keluhan',
            'title'   => 'Keluhan Baru dari Sekolah',
            'message' => $sekolah->nama_sekolah . ' mengirim keluhan: ' . $request->kategori,
            'link'    => url('/pemerintah/keluhan'),
            'is_read' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Keluhan berhasil dikirim dan belum diproses'
        ]);
    }

    public function statusSaya()
    {
        $sekolahId = Auth::user()->sekolah->id;

        $keluhan = MbgKeluhan::where('sekolah_id', $sekolahId)
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($k) {
                return [
                    'id'        => $k->id,
                    'kategori'  => $k->kategori,
                    'tanggal'   => $k->tanggal->format('d F Y'),
                    'status'    => $k->status,
                ];
            });

        return response()->json($keluhan);
    }
}