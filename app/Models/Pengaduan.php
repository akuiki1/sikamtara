<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduans';

    protected $primaryKey = 'id_pengaduan';

    protected $fillable = [
        'id_user',
        'judul_pengaduan',
        'isi_pengaduan',
        'lampiran',
        'status',
    ];

    public $timestamps = true;

    /**
     * Relasi ke tabel users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    /**
     * Relasi ke status terakhir
     */
    public function statusTerakhir()
    {
        return $this->hasOne(RiwayatStatusPengaduan::class, 'id_pengaduan')->latestOfMany('tanggal_perubahan');
    }
    public function statuses()
    {
        return $this->hasMany(RiwayatStatusPengaduan::class, 'id_pengaduan');
    }
}
