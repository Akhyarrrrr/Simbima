<?php

namespace App\Notifications;

use App\Models\PengajuanBimbingan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengajuanDiterima extends Notification
{
    use Queueable;

    public function __construct(private readonly PengajuanBimbingan $pengajuan)
    {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $dosenNama = $this->pengajuan->dosen->user->name;

        return [
            'type' => 'pengajuan_diterima',
            'message' => "Pengajuan bimbingan Anda ke {$dosenNama} telah diterima.",
            'pengajuan_id' => $this->pengajuan->id,
            'dosen_id' => $this->pengajuan->dosen_id,
            'dosen_nama' => $dosenNama,
        ];
    }
}
