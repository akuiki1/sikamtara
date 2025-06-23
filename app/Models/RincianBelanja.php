<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RincianBelanja extends Model
{
    use HasFactory;

    protected $table = 'rincian_belanja';
    protected $primaryKey = 'id_rincian_belanja';

    protected $fillable = [
        'id_belanja',
        'id_tahun_anggaran',
        'nama',
        'anggaran',
        'realisasi',
    ];

    public function belanja()
    {
        return $this->belongsTo(Belanja::class, 'id_belanja');
    }

    public function tahunAnggaran()
    {
        return $this->belongsTo(TahunAnggaran::class, 'id_tahun_anggaran');
    }
}
