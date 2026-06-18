<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mahasiswa extends Model
{
    protected $fillable = [
        'user_id',
        'nim',
        'angkatan',
        'bidang_minat_id',
    ];

    protected function casts(): array
    {
        return [
            'angkatan' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bidangMinat(): BelongsTo
    {
        return $this->belongsTo(BidangMinat::class);
    }

    public function pengajuanBimbingans(): HasMany
    {
        return $this->hasMany(PengajuanBimbingan::class);
    }

    public function bimbingan(): HasOne
    {
        return $this->hasOne(Bimbingan::class);
    }
}
