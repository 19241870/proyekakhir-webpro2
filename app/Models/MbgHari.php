<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MbgHari extends Model
{
    use HasFactory;
    protected $table = 'mbg_hari';

    protected $fillable = [
        'tanggal',
        'hari',
        'is_active'
    ];
}