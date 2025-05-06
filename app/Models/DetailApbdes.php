<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailApbdes extends Model
{
    use HasFactory;

    protected $table = 'detail_apbdes';
    protected $primaryKey = 'id_rincian';

    protected $fillable = [
        'id_apbdes',
        'kategori',
        'judul',
        'sub_judul',
        'anggaran',
        'realisasi',
    ];

    public $timestamps = false;

    // Relasi ke apbdes
    public function apbdes()
    {
        return $this->belongsTo(Apbdes::class, 'id_apbdes', 'id_apbdes');
    }
}
