<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramPembangunanDesa extends Model
{
    protected $table = 'program_pembangunan_desa';

    protected $fillable = [
        'nama_program',
        'jenis_program',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'anggaran',
        'sumber_dana',
        'penanggung_jawab',
        'status',
        'deskripsi',
        'foto_dokumentasi',
    ];
}
