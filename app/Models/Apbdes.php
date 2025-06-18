<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apbdes extends Model
{
    use HasFactory;

    protected $table = 'apbdes';
    protected $primaryKey = 'id_apbdes';

    protected $fillable = [
        'tahun',
        'total_anggaran',
        'total_realisasi',
    ];

    public $timestamps = false;

    // Relasi ke detail_apbdes
    public function detail_apbdes()
    {
        return $this->hasMany(DetailApbdes::class, 'id_apbdes', 'id_apbdes');
    }
}
