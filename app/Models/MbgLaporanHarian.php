<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MbgLaporanHarian extends Model
{
    use HasFactory;
    protected $table = 'mbg_laporan_harian';

    protected $fillable = [
        'sekolah_id',
        'menu_id',
        'tanggal',
        'jam_lapor',
        'rating',
        'jumlah_sisa',
        'status',
        'jumlah_porsi',
        'kendala',
        'catatan',
        'foto'
    ];

    public function sekolah()
    {
        return $this->belongsTo(ManajemenSekolah::class);
    }

    public function menu()
    {
        return $this->belongsTo(MbgMenu::class, 'menu_id');
    }
}