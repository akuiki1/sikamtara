<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    protected $table = 'verifikasi';

    protected $fillable = [
        'id_user',
        'foto_ktp',
        'selfie_ktp',
        'foto_kk',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
