<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RincianAnggaran extends Model
{
    use HasFactory;
    
    protected $table = 'rincian_anggaran';
    protected $primaryKey = 'id_rincian_anggaran';
    public $timestamps = false;

    protected $fillable = [
        'id_sub_kategori_anggaran',
        'id_tahun_anggaran',
        'nama',
        'anggaran',
        'realisasi',
        'selisih',
    ];

    public function subKategori()
    {
        return $this->belongsTo(SubKategoriAnggaran::class, 'id_sub_kategori_anggaran', 'id_sub_kategori_anggaran');
    }

    public function tahunAnggaran()
    {
        return $this->belongsTo(TahunAnggaran::class, 'id_tahun_anggaran', 'id_tahun_anggaran');
    }
}
