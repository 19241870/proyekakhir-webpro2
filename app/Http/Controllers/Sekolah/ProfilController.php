<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $sekolah = Auth::user()->sekolah; // relasi ke manajemen_sekolah

        return view('sekolah.profil', compact('sekolah'));
    }

    public function update(Request $request)
    {
        $sekolah = Auth::user()->sekolah;

        $request->validate([
            'nama_sekolah'   => 'required',
            'npsn'           => 'required',
            'alamat'         => 'nullable',
            'jumlah_siswa'   => 'nullable|integer',
            'kepala_sekolah' => 'nullable|string',
            'telepon'        => 'nullable|string',
        ]);

        $sekolah->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Profil sekolah berhasil diperbarui'
        ]);
    }

}