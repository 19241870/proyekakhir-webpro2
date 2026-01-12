<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MbgLaporanHarian;
use App\Models\MbgMenu;
use App\Models\ManajemenSekolah;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $sekolahId = Auth::user()->sekolah->id;
        $jumlahPorsiPemerintah = ManajemenSekolah::where('id', $sekolahId)->value('jumlah_porsi');
        $menus = MbgMenu::where('sekolah_id', $sekolahId)
                    ->orderBy('nama_menu', 'asc')
                    ->get();
        return view('sekolah.input-laporan', compact('menus', 'jumlahPorsiPemerintah'));
    }

    public function store(Request $request)
    {
        $sekolah = Auth::user()->sekolah;

        $request->validate([
            'tanggal'       => 'required|date',
            'jam_lapor'     => 'required|date_format:H:i',
            'rating'        => 'required|numeric|min:1|max:5',
            'jumlah_sisa'    => 'required|integer|min:0',
            'menu_id'       => 'required|exists:mbg_menu,id',
            'jumlah_porsi'  => 'required|integer|min:1',
            'kendala'       => 'nullable|string',
            'catatan'       => 'nullable|string',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan', 'public');
        }

        MbgLaporanHarian::create([
            'sekolah_id'    => $sekolah->id,
            'menu_id'       => $request->menu_id,
            'tanggal'       => $request->tanggal,
            'jam_lapor'     => $request->jam_lapor,
            'rating'        => $request->rating,
            'jumlah_sisa'   => $request->jumlah_sisa,
            'status'        => 'Pending',
            'jumlah_porsi'  => $request->jumlah_porsi,
            'kendala'       => $request->kendala,
            'catatan'       => $request->catatan,
            'foto'          => $fotoPath,
        ]);

        Notification::create([
            'user_id' => null, // admin pemerintah (global)
            'role'    => 'admin',
            'type'    => 'laporan_harian',
            'title'   => 'Laporan Harian Baru dari Sekolah',
            'message' => $sekolah->nama_sekolah . ' mengirim laporan harian untuk tanggal ' . Carbon::parse($request->tanggal)->format('d M Y'),
            'link'    => url('/pemerintah/laporan'),
            'is_read' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan harian berhasil dikirim'
        ]);
    }

}