<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturPemerintahan extends Model
{
    protected $table = 'struktur_pemerintahan';

    protected $fillable = [
        'id',
        'id_user',
        'jabatan',
        'deskripsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
