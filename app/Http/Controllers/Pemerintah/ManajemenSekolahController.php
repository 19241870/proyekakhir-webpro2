<?php

namespace App\Http\Controllers\Pemerintah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManajemenSekolah;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ManajemenSekolahController extends Controller
{
    public function index()
    {
        $sekolah = ManajemenSekolah::orderBy('nama_sekolah')->get();
        $usersSekolah = User::where('role', 'sekolah')->get();
        return view('pemerintah.manajemen_sekolah', compact('sekolah', 'usersSekolah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'user_id'      => 'required|exists:users,id',
            'npsn'         => 'required|string|unique:manajemen_sekolah,npsn',
            'jenjang'      => 'required',
            'status'       => 'required',
            'kecamatan'    => 'required',
            'jumlah_porsi'        => 'required|integer',
            'alamat'       => 'nullable',
            'foto'         => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')
                ->store('sekolah', 'public');
        }

        ManajemenSekolah::create([
            'nama_sekolah' => $request->nama_sekolah,
            'user_id'      => $request->user_id,
            'npsn'         => $request->npsn,
            'jenjang'      => $request->jenjang,
            'status'       => $request->status,
            'kecamatan'    => $request->kecamatan,
            'jumlah_porsi' => $request->jumlah_porsi,
            'alamat'       => $request->alamat,
            'foto'         => $fotoPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data sekolah berhasil ditambahkan'
        ]);
    }

    public function edit($id)
    {
        $sekolah = ManajemenSekolah::findOrFail($id);
        return response()->json($sekolah);
    }

    public function update(Request $request, $id)
    {
        $sekolah = ManajemenSekolah::findOrFail($id);

        // ================= VALIDASI =================
        $request->validate([
            'nama_sekolah'   => 'required',
            'user_id'        => 'required|exists:users,id',
            'npsn'           => 'required',
            'jenjang'        => 'required',
            'status'         => 'required',
            'kecamatan'      => 'nullable',
            'jumlah_porsi'   => 'nullable|numeric',
            'alamat'         => 'nullable',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ================= HANDLE FOTO =================
        if ($request->hasFile('foto')) {

            // 🔥 HAPUS FOTO LAMA JIKA ADA
            if ($sekolah->foto && Storage::disk('public')->exists($sekolah->foto)) {
                Storage::disk('public')->delete($sekolah->foto);
            }

            // SIMPAN FOTO BARU
            $fotoPath = $request->file('foto')->store(
                'sekolah',
                'public'
            );

            $sekolah->foto = $fotoPath;
        }

        // ================= UPDATE DATA =================
        $sekolah->update([
            'nama_sekolah'   => $request->nama_sekolah,
            'user_id'        => $request->user_id,
            'npsn'           => $request->npsn,
            'jenjang'        => $request->jenjang,
            'status'         => $request->status,
            'kecamatan'      => $request->kecamatan,
            'jumlah_porsi'   => $request->jumlah_porsi,
            'alamat'         => $request->alamat,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data sekolah berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $sekolah = ManajemenSekolah::findOrFail($id);

        // HAPUS FOTO JIKA ADA
        if ($sekolah->foto && Storage::disk('public')->exists($sekolah->foto)) {
            Storage::disk('public')->delete($sekolah->foto);
        }

        $sekolah->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data sekolah berhasil dihapus'
        ]);
    }
}   
