<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

     protected $table = 'notifications';

    public $timestamps = false; 
    // karena tabel hanya punya created_at (tanpa updated_at)

    protected $fillable = [
        'user_id',
        'role',
        'type',
        'title',
        'message',
        'link',
        'is_read',
        'created_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // ======================
    // RELASI KE USER (OPTIONAL)
    // ======================
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}