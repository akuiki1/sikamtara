<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'nik',
        'email',
        'password',
        'role',
        'google_id',
        'foto',
        'status_verifikasi'
    ];

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'id_user';
    }

    // User.php
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'nik', 'nik');
    }
}
