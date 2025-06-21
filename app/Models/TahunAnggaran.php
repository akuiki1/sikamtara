<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAnggaran extends Model
{
    protected $table = 'tahun_anggaran';
    protected $fillable = ['tahun'];

    public function rincianAnggaran()
    {
        return $this->hasMany(RincianAnggaran::class, 'tahun_id');
    }

    public function penerimaanPembiayaan()
    {
        return $this->hasMany(PenerimaanPembiayaan::class, 'tahun_id');
    }

    public function pengeluaranPembiayaan()
    {
        return $this->hasMany(PengeluaranPembiayaan::class, 'tahun_id');
    }
}
