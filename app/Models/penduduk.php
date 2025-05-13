<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penduduk extends Model
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
    public function keluarga()
    {
        return $this->belongsTo(keluarga::class, 'kode_keluarga', 'kode_keluarga');
    }
}
