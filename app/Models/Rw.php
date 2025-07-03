<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rw extends Model
{
    protected $table = 'rw';

    protected $fillable = ['rw'];

    public function rts(): HasMany
    {
        return $this->hasMany(Rt::class, 'id_rw');
    }
}
