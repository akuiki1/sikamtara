<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatStatusPengaduan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_status_pengaduan';
    protected $primaryKey = 'id_riwayat_status_pengaduan';

    protected $fillable = [
        'id_pengaduan',
        'status',
        'tanggal_perubahan',
        'keterangan',
        'diubah_oleh',
    ];

    // Relasi ke tabel Pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }

    // Relasi ke tabel User (yang mengubah status)
    public function user()
    {
        return $this->belongsTo(User::class, 'diubah_oleh', 'id_user');
    }

    // untuk mendapatkan diubah oleh dan status terakhir berdasarkan tanggal perubahan
    protected static function booted()
    {
        static::creating(function ($model) {
            // Set tanggal_perubahan jika belum diisi
            $model->tanggal_perubahan = $model->tanggal_perubahan ?? now();

            // Set diubah_oleh dari user yang sedang login jika belum diisi
            if (is_null($model->diubah_oleh) && Auth::check()) {
                $model->diubah_oleh = Auth::id();
            }
        });
    }
}
