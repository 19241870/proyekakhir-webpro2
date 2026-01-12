<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MbgMenu;
use Illuminate\Support\Facades\Auth;

class KelolaMenuController extends Controller
{
    public function index()
    {
        return view('sekolah.menu');
    }

    public function getMenuData()
    {
        $user = Auth::user();
        
        // ambil sekolah dari relasi hasOne
        $sekolah = $user->sekolah;
        if (!$sekolah) {
            return response()->json([]);
        }

        $menus = MbgMenu::with('hari')
            ->where('sekolah_id', $sekolah->id)
            ->whereHas('hari', fn ($q) => $q->where('is_active', 1))
            ->where('is_active', 1)
            ->orderBy('mbg_hari_id')
            ->get()
            ->map(function ($m) {
                return [
                    'hari'     => $m->hari->hari,
                    'menu'     => $m->nama_menu,
                    'kalori'   => $m->kalori,
                    'protein'  => $m->protein,
                ];
            });

        return response()->json($menus);
    }
}