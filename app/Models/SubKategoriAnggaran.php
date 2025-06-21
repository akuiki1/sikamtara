<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKategoriAnggaran extends Model
{
    protected $table = 'sub_kategori_anggaran';
    protected $fillable = ['kategori_id', 'nama'];

    public function kategori()
    {
        return $this->belongsTo(KategoriAnggaran::class, 'kategori_id');
    }

    public function rincian()
    {
        return $this->hasMany(RincianAnggaran::class, 'sub_kategori_id');
    }
}
