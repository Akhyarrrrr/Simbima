<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bimbingan extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'dospem1_id',
        'dospem2_id',
        'judul_ta',
        'status',
        'boleh_sempro',
        'boleh_semhas',
        'boleh_sidang',
    ];

    protected function casts(): array
    {
        return [
            'boleh_sempro' => 'boolean',
            'boleh_semhas' => 'boolean',
            'boleh_sidang' => 'boolean',
        ];
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dospem1(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dospem1_id');
    }

    public function dospem2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dospem2_id');
    }

    public function catatans(): HasMany
    {
        return $this->hasMany(CatatanBimbingan::class)->latest();
    }
}
