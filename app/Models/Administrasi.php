<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Administrasi extends Model
{
   use HasFactory;

    protected $primaryKey = 'id_administrasi';
    protected $fillable = ['nama_administrasi', 'deskripsi', 'persyaratan', 'form'];

    public function user()
    {
        return $this->belongsTo(User::class, 'penulis', 'id_user');
    }
}
