<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MbgKeluhan extends Model
{
    use HasFactory;
    protected $table = 'mbg_keluhan';

    protected $fillable = [
        'kategori',
        'sekolah_id',
        'deskripsi',
        'foto',
        'status',
        'tanggal'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function sekolah()
    {
        return $this->belongsTo(ManajemenSekolah::class, 'sekolah_id');
    }
}