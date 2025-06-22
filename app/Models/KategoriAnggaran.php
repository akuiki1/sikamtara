<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriAnggaran extends Model
{
    use HasFactory;
    
    protected $table = 'kategori_anggaran';
    protected $primaryKey = 'id_kategori_anggaran';
    public $timestamps = false;

    protected $fillable = ['nama'];

    public function subKategori()
    {
        return $this->hasMany(SubKategoriAnggaran::class, 'id_kategori_anggaran', 'id_kategori_anggaran');
    }
}
