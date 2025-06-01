<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $primaryKey = 'id_pengumuman';
    protected $fillable = ['judul_pengumuman', 'isi_pengumuman', 'file_lampiran', 'tanggal_publish', 'penulis', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'penulis', 'id_user');
    }
}
