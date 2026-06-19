<?php

namespace App\Notifications;

use App\Models\PengajuanBimbingan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengajuanBaru extends Notification
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
        $mahasiswa = $this->pengajuan->mahasiswa;
        $mahasiswaNama = $mahasiswa->user->name;

        return [
            'type' => 'pengajuan_baru',
            'message' => "{$mahasiswaNama} ({$mahasiswa->nim}) mengajukan bimbingan kepada Anda.",
            'pengajuan_id' => $this->pengajuan->id,
            'mahasiswa_id' => $this->pengajuan->mahasiswa_id,
            'mahasiswa_nama' => $mahasiswaNama,
            'nim' => $mahasiswa->nim,
        ];
    }
}
