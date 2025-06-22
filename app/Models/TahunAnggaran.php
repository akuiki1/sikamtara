<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TahunAnggaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_anggaran';
    protected $primaryKey = 'id_tahun_anggaran';
    protected $fillable = ['tahun'];

    public function rincianAnggaran()
    {
        return $this->hasMany(RincianAnggaran::class, 'id_tahun_anggaran');
    }

    public function penerimaanPembiayaan()
    {
        return $this->hasMany(PenerimaanPembiayaan::class, 'id_tahun_anggaran');
    }

    public function pengeluaranPembiayaan()
    {
        return $this->hasMany(PengeluaranPembiayaan::class, 'id_tahun_anggaran');
    }
}
