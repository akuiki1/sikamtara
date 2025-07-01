<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keluarga extends Model
{
    use HasFactory;

    protected $table = 'keluarga'; // Nama tabel

    protected $primaryKey = 'kode_keluarga'; // Primary key

    public $incrementing = false; // Karena ID KK bukan auto-increment

    protected $keyType = 'string';

    protected $fillable = [
        'kode_keluarga',
        'nik_kepala_keluarga',
        'alamat',
        'dusun',
        'rt',
        'rw',
    ];

    // Semua anggota keluarga
    public function penduduk()
    {
        return $this->hasMany(Penduduk::class, 'kode_keluarga', 'kode_keluarga');
    }

    // Kepala keluarga
    public function kepalaKeluarga()
    {
        return $this->hasOne(Penduduk::class, 'kode_keluarga', 'kode_keluarga')
            ->where('hubungan', 'Kepala Keluarga');
    }
}
