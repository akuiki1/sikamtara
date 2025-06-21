<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriAnggaran extends Model
{
    protected $table = 'kategori_anggaran';
    protected $fillable = ['nama'];

    public function subKategori()
    {
        return $this->hasMany(SubKategoriAnggaran::class, 'kategori_id');
    }
}
