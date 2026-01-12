<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MbgKeluhan;
use Carbon\Carbon;
use App\Models\Notification;

class NotifikasiController extends Controller
{
     public function index()
    {
        $user = Auth::user();

        // ===============================
        // FILTER BERDASARKAN ROLE
        // ===============================
        $query = Notification::orderBy('created_at', 'desc');

        if ($user->role === 'admin') {
            $query->where('role', 'admin');
        } else {
            // ROLE SEKOLAH
            $query->where('role', 'sekolah')
                  ->where('user_id', $user->sekolah->id);
        }

        $notifs = $query->limit(5)->get();

        return response()->json([
            'count' => (clone $query)->where('is_read', 0)->count(),
            'data'  => $notifs->map(function ($n) {
                return [
                    'id'      => $n->id,
                    'judul'   => $n->title,
                    'pesan'   => $n->message,
                    'is_read' => $n->is_read,
                    'sekolah' => $n->role === 'admin' ? optional($n->user)->sekolah->nama_sekolah ?? null : null,
                    'icon'    => $n->type === 'keluhan' ? '⚠️' : '🔔',
                    'waktu'   => Carbon::parse($n->created_at)->diffForHumans(),
                    'link'    => $n->link
                ];
            })
        ]);
    }

    public function markReadOne(Request $request)
    {
        $user = Auth::user();

        Notification::where('id', $request->id)
            ->where('is_read', 0)
            ->where(function ($q) use ($user) {
                if ($user->role === 'admin') {
                    $q->where('role', 'admin');
                } else {
                    $q->where('role', 'sekolah')
                    ->where('user_id', $user->sekolah->id);
                }
            })
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }

}