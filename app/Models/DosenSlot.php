<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DosenSlot extends Model
{
    protected $fillable = [
        'dosen_id',
        'angkatan',
        'max_slot',
    ];

    protected function casts(): array
    {
        return [
            'angkatan' => 'integer',
            'max_slot' => 'integer',
        ];
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class);
    }
}
