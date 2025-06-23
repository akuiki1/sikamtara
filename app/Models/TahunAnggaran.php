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

    public function rincianBelanja()
    {
        return $this->hasMany(RincianBelanja::class, 'id_tahun_anggaran');
    }

    public function pembiayaan()
    {
        return $this->hasMany(Pembiayaan::class, 'id_tahun_anggaran');
    }

    public function pendapatan()
    {
        return $this->hasMany(Pendapatan::class, 'id_tahun_anggaran');
    }

    public function totalPendapatan()
    {
        return $this->pendapatan()->sum('anggaran');
    }

    public function totalBelanja()
    {
        return $this->rincianBelanja()->sum('anggaran');
    }

    public function totalPembiayaan()
    {
        $penerimaan = $this->pembiayaan()->where('jenis', 'penerimaan')->sum('anggaran');
        $pengeluaran = $this->pembiayaan()->where('jenis', 'pengeluaran')->sum('anggaran');
        return $penerimaan - $pengeluaran;
    }
}
