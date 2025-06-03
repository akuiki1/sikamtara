<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanAdministrasi extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_administrasis';

    protected $primaryKey = 'id_pengajuan_administrasi';

    protected $fillable = [
        'id_administrasi',
        'id_user',
        'tanggal_pengajuan',
        'form',
        'lampiran',
        'status_pengajuan',
        'surat_final',
    ];

    public $timestamps = true;

    /**
     * Relasi ke tabel administrasis
     */
    public function administrasi()
    {
        return $this->belongsTo(Administrasi::class, 'id_administrasi');
    }

    /**
     * Relasi ke tabel users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
