<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatatanBimbingan extends Model
{
    protected $fillable = [
        'bimbingan_id',
        'user_id',
        'kategori',
        'isi',
    ];

    public function bimbingan(): BelongsTo
    {
        return $this->belongsTo(Bimbingan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
