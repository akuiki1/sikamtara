<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk'; // Nama tabel

    protected $primaryKey = 'nik'; // Primary key

    public $incrementing = false; // Karena NIK bukan auto-increment

    protected $keyType = 'string';

    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pendidikan',
        'pekerjaan',
        'status_perkawinan',
        'golongan_darah',
        'hubungan',
        'kewarganegaraan',
        'kode_keluarga',
        'status_tinggal',
    ];

    // Relasi ke KK (keluarga)
    public function Keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'kode_keluarga', 'kode_keluarga');
    }
}
