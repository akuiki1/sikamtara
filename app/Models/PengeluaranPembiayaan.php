<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengeluaranPembiayaan extends Model
{
    use HasFactory;
    
    protected $table = 'pengeluaran_pembiayaan';
    protected $primaryKey = 'id_pengeluaran_pembiayaan';
    public $timestamps = false;

    protected $fillable = ['id_tahun_anggaran', 'nama', 'nilai'];

    public function tahunAnggaran()
    {
        return $this->belongsTo(TahunAnggaran::class, 'id_tahun_anggaran', 'id_tahun_anggaran');
    }
}
