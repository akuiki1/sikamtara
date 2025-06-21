<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengeluaranPembiayaan extends Model
{
    protected $table = 'pengeluaran_pembiayaan';
    protected $fillable = ['tahun_id', 'nama', 'nilai'];

    public function tahun()
    {
        return $this->belongsTo(TahunAnggaran::class, 'tahun_id');
    }
}
