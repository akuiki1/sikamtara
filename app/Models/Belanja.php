<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Belanja extends Model
{
    use HasFactory;

    protected $table = 'belanja';
    protected $primaryKey = 'id_belanja';

    protected $fillable = ['nama'];

    public function rincianBelanja()
    {
        return $this->hasMany(RincianBelanja::class, 'id_belanja');
    }
}
