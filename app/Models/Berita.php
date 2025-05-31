<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_berita';
    protected $fillable = ['judul_berita', 'isi_berita', 'gambar_cover', 'tanggal_publish', 'penulis', 'status', 'tags'];

    public function user()
    {
        return $this->belongsTo(User::class, 'penulis', 'id_user');
    }
}
