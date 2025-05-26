<?php

namespace App\Models;

use App\Models\Keluarga;
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
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'pekerjaan',
        'hubungan',
        'status_perkawinan',
        'golongan_darah',
        'kewarganegaraan',
        'kode_keluarga',
        'alamat',
        'dusun',
        'rt',
        'rw',
        'status_tinggal',
    ];

    // Relasi ke KK (keluarga)
    public function Keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'kode_keluarga', 'kode_keluarga');
    }
}
