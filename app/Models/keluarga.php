<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;

    protected $table = 'keluarga'; // Nama tabel

    protected $primaryKey = 'kode_keluarga'; // Primary key

    public $incrementing = false; // Karena ID KK bukan auto-increment

    protected $keyType = 'string';

    protected $fillable = [
        'kode_keluarga',
        'kepala_keluarga',
        'alamat',
        'dusun',
        'rt',
        'rw',
        'tanggal_dibuat',
    ];

    // Relasi ke penduduk-penduduk dalam KK ini
    public function Penduduk()
    {
        return $this->hasMany(Penduduk::class, 'kode_keluarga', 'kode_keluarga');
    }
}
