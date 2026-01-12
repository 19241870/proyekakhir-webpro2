<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MbgMenu extends Model
{
    use HasFactory;
    protected $table = 'mbg_menu';
    protected $fillable = [
        'mbg_hari_id',
        'sekolah_id',
        'nama_menu',
        'kalori',
        'protein',
        'is_active'
    ];
    
    public function hari()
    {
        return $this->belongsTo(MbgHari::class, 'mbg_hari_id');
    }

    public function sekolah()
    {
        return $this->belongsTo(ManajemenSekolah::class, 'sekolah_id');
    }
}