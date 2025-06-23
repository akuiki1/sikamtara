<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubKategoriAnggaran extends Model
{
    use HasFactory;
    
    protected $table = 'sub_kategori_anggaran';
    protected $primaryKey = 'id_sub_kategori_anggaran';
    public $timestamps = false;

    protected $fillable = ['id_kategori_anggaran', 'nama'];

    public function kategoriAnggaran()
    {
        return $this->belongsTo(KategoriAnggaran::class, 'id_kategori_anggaran', 'id_kategori_anggaran');
    }

    public function rincianAnggaran()
    {
        return $this->hasMany(RincianAnggaran::class, 'id_sub_kategori_anggaran', 'id_sub_kategori_anggaran');
    }
}
