<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rt extends Model
{
    protected $table = 'rt';

    protected $fillable = ['id_rw', 'rt'];

    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class, 'id_rw');
    }
}
