<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembiayaan extends Model
{
    use HasFactory;

    protected $table = 'pembiayaan';
    protected $primaryKey = 'id_pembiayaan';

    protected $fillable = [
        'id_tahun_anggaran',
        'nama',
        'jenis',
        'anggaran',
        'realisasi',
    ];

    public function tahunAnggaran()
    {
        return $this->belongsTo(TahunAnggaran::class, 'id_tahun_anggaran');
    }
}
