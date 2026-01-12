<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManajemenSekolah extends Model
{
    protected $table = 'manajemen_sekolah';

    protected $fillable = [
        'nama_sekolah',
        'user_id',
        'npsn',
        'jenjang',
        'status',
        'kecamatan',
        'jumlah_porsi',
        'alamat',
        'foto'
    ];

    public function keluhan()
    {
        return $this->hasMany(MbgKeluhan::class, 'sekolah_id');
    }
}