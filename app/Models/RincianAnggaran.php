<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RincianAnggaran extends Model
{
    protected $table = 'rincian_anggaran';
    protected $fillable = ['sub_kategori_id', 'tahun_id', 'nama', 'anggaran', 'realisasi'];

    public function subKategori()
    {
        return $this->belongsTo(SubKategoriAnggaran::class, 'sub_kategori_id');
    }

    public function tahun()
    {
        return $this->belongsTo(TahunAnggaran::class, 'tahun_id');
    }
}

