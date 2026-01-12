<?php

namespace App\Http\Controllers\Pemerintah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MbgHari;
use App\Models\MbgMenu;
use App\Models\ManajemenSekolah;
use Carbon\Carbon;

class KelolaMenuController extends Controller
{
    public function index()
    {
        $menus = MbgMenu::with(['hari', 'sekolah'])->orderBy('mbg_hari_id')->get();
        $hariAktif = MbgHari::where('is_active', 1)->get();
        $sekolah   = ManajemenSekolah::orderBy('nama_sekolah')->get();
        return view('pemerintah.menu', compact('menus', 'hariAktif', 'sekolah'));
    }

    public function listHari()
    {
        return response()->json(
            MbgHari::orderBy('tanggal')->get()
        );
    }

    public function storeHari(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:mbg_hari,tanggal'
        ]);

        $hari = Carbon::parse($request->tanggal)
            ->locale('id')
            ->translatedFormat('l');

        $data = MbgHari::create([
            'tanggal' => $request->tanggal,
            'hari'    => ucfirst($hari),
            'is_active' => 1
        ]);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // Toggle Hari Active/Inactive
    public function toggleHari(Request $request)
    {
        $hari = MbgHari::findOrFail($request->id);
        $hari->is_active = !$hari->is_active;
        $hari->save();

        return response()->json(['status' => 'success', 'message' => 'Status hari berhasil diubah']);
    }

    // Update Hari
    public function updateHari(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'tanggal' => 'required|date|unique:mbg_hari,tanggal,' . $request->id
        ]);

        $hariText = Carbon::parse($request->tanggal)
            ->locale('id')
            ->translatedFormat('l');

        $hari = MbgHari::findOrFail($request->id);
        $hari->update([
            'tanggal' => $request->tanggal,
            'hari' => ucfirst($hariText)
        ]);

        return response()->json(['status' => 'success', 'message' => 'Hari berhasil diupdate']);
    }

    public function deleteHari($id)
    {
        MbgHari::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    // Store Menu
    public function storeMenu(Request $request)
    {
        $request->validate([
            'mbg_hari_id' => 'required|exists:mbg_hari,id',
            'sekolah_id' => 'required|exists:manajemen_sekolah,id',
            'nama_menu' => 'required|string',
            'kalori' => 'nullable|integer',
            'protein' => 'nullable|integer',
        ]);

         // ❗ Prevent double menu
        $exists = MbgMenu::where('mbg_hari_id', $request->mbg_hari_id)
            ->where('sekolah_id', $request->sekolah_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu untuk sekolah dan hari ini sudah ada'
            ], 422);
        }

        MbgMenu::create([
            'mbg_hari_id' => $request->mbg_hari_id,
            'sekolah_id' => $request->sekolah_id,
            'nama_menu' => $request->nama_menu,
            'kalori' => $request->kalori,
            'protein' => $request->protein,
            'is_active'   => $request->has('is_active'),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Menu berhasil ditambahkan']);
    }

    // show menu
    public function showMenu($id)
    {
        $menu = MbgMenu::findOrFail($id);
        return response()->json($menu);
    }

    // update menu
    public function updateMenu(Request $request, $id)
    {
        $menu = MbgMenu::findOrFail($id);
        $request->validate([
            'mbg_hari_id' => 'required|exists:mbg_hari,id',
            'sekolah_id' => 'required|exists:manajemen_sekolah,id',
            'nama_menu' => 'required|string',
            'kalori' => 'nullable|integer',
            'protein' => 'nullable|integer',
        ]);
        // ❗ Prevent duplicate except self
        $exists = MbgMenu::where('mbg_hari_id', $request->mbg_hari_id)
            ->where('sekolah_id', $request->sekolah_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu untuk sekolah dan hari ini sudah ada'
            ], 422);
        }

        $menu->update([
            'mbg_hari_id' => $request->mbg_hari_id,
            'sekolah_id' => $request->sekolah_id,
            'nama_menu' => $request->nama_menu,
            'kalori' => $request->kalori,
            'protein' => $request->protein,
            'is_active'   => $request->has('is_active'),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Menu berhasil diperbarui']);
    }

    public function deleteMenu($id)
    {
        MbgMenu::findOrFail($id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Menu berhasil dihapus']);
    }

    public function menuBySekolah(Request $request)
    {
        $request->validate([
            'sekolah_id' => 'required|exists:manajemen_sekolah,id'
        ]);

        $menus = MbgMenu::with(['hari'])
            ->where('sekolah_id', $request->sekolah_id)
            ->orderBy('mbg_hari_id')
            ->get()
            ->map(function ($m) {
                return [
                    'id'        => $m->id,
                    'tanggal'   => \Carbon\Carbon::parse($m->hari->tanggal)
                                      ->format('d-m-Y'),
                    'hari'      => $m->hari->hari,
                    'nama_menu' => $m->nama_menu,
                    'kalori'    => $m->kalori,
                    'protein'   => $m->protein,
                    'is_active' => $m->is_active,
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $menus
        ]);
    }

}   
