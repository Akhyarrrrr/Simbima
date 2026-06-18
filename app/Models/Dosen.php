<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'bidang_minat_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bidangMinat(): BelongsTo
    {
        return $this->belongsTo(BidangMinat::class);
    }

    public function dosenSlots(): HasMany
    {
        return $this->hasMany(DosenSlot::class);
    }

    public function pengajuanBimbingans(): HasMany
    {
        return $this->hasMany(PengajuanBimbingan::class);
    }

    public function bimbingansDospem1(): HasMany
    {
        return $this->hasMany(Bimbingan::class, 'dospem1_id');
    }

    public function bimbingansDospem2(): HasMany
    {
        return $this->hasMany(Bimbingan::class, 'dospem2_id');
    }

    public function sisaSlot(int $angkatan): int
    {
        $maxSlot = $this->dosenSlots()
            ->where('angkatan', $angkatan)
            ->value('max_slot') ?? 0;

        $bimbinganAktif = Bimbingan::query()
            ->where('status', 'aktif')
            ->where(function ($query) {
                $query->where('dospem1_id', $this->id)
                    ->orWhere('dospem2_id', $this->id);
            })
            ->whereHas('mahasiswa', function ($query) use ($angkatan) {
                $query->where('angkatan', $angkatan);
            })
            ->count();

        return (int) $maxSlot - $bimbinganAktif;
    }
}
