<?php

namespace Tests\Feature;

use App\Models\BidangMinat;
use App\Models\Dosen;
use App\Models\DosenSlot;
use App\Models\Mahasiswa;
use App\Models\PengajuanBimbingan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengajuan_baru_notification_is_sent_to_dosen(): void
    {
        $bidangMinat = BidangMinat::create(['nama' => 'Rekayasa Perangkat Lunak']);
        $mahasiswa = $this->createMahasiswa($bidangMinat);
        $dosen = $this->createDosen($bidangMinat);

        DosenSlot::create([
            'dosen_id' => $dosen->id,
            'angkatan' => 2021,
            'max_slot' => 10,
        ]);

        $this
            ->actingAs($mahasiswa->user)
            ->post(route('mahasiswa.pengajuan.store'), ['dosen_id' => $dosen->id])
            ->assertRedirect(route('mahasiswa.dashboard'));

        $notification = $dosen->user->notifications()->first();

        $this->assertNotNull($notification);
        $this->assertSame('pengajuan_baru', $notification->data['type']);
        $this->assertStringContainsString($mahasiswa->user->name, $notification->data['message']);
        $this->assertStringContainsString($mahasiswa->nim, $notification->data['message']);
    }

    public function test_pengajuan_approval_and_rejection_notifications_are_sent_to_mahasiswa(): void
    {
        $bidangMinat = BidangMinat::create(['nama' => 'Data Mining']);
        $mahasiswaDiterima = $this->createMahasiswa($bidangMinat);
        $mahasiswaDitolak = $this->createMahasiswa($bidangMinat);
        $dosen = $this->createDosen($bidangMinat);

        DosenSlot::create([
            'dosen_id' => $dosen->id,
            'angkatan' => 2021,
            'max_slot' => 10,
        ]);

        $pengajuanDiterima = PengajuanBimbingan::create([
            'mahasiswa_id' => $mahasiswaDiterima->id,
            'dosen_id' => $dosen->id,
            'status' => 'pending',
        ]);

        $pengajuanDitolak = PengajuanBimbingan::create([
            'mahasiswa_id' => $mahasiswaDitolak->id,
            'dosen_id' => $dosen->id,
            'status' => 'pending',
        ]);

        $this
            ->actingAs($dosen->user)
            ->patch(route('dosen.pengajuan.approve', $pengajuanDiterima))
            ->assertRedirect(route('dosen.dashboard'));

        $this
            ->actingAs($dosen->user)
            ->patch(route('dosen.pengajuan.reject', $pengajuanDitolak), [
                'catatan_penolakan' => 'Topik belum sesuai.',
            ])
            ->assertRedirect(route('dosen.dashboard'));

        $diterimaNotification = $mahasiswaDiterima->user->notifications()->first();
        $ditolakNotification = $mahasiswaDitolak->user->notifications()->first();

        $this->assertSame('pengajuan_diterima', $diterimaNotification->data['type']);
        $this->assertStringContainsString('telah diterima', $diterimaNotification->data['message']);
        $this->assertSame('pengajuan_ditolak', $ditolakNotification->data['type']);
        $this->assertStringContainsString('Topik belum sesuai.', $ditolakNotification->data['message']);
    }

    public function test_user_can_mark_all_notifications_as_read(): void
    {
        $bidangMinat = BidangMinat::create(['nama' => 'Jaringan']);
        $mahasiswa = $this->createMahasiswa($bidangMinat);
        $dosen = $this->createDosen($bidangMinat);

        $pengajuan = PengajuanBimbingan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'dosen_id' => $dosen->id,
            'status' => 'pending',
        ]);

        $mahasiswa->user->notify(new \App\Notifications\PengajuanDiterima($pengajuan->load('dosen.user')));

        $this->assertSame(1, $mahasiswa->user->unreadNotifications()->count());

        $this
            ->actingAs($mahasiswa->user)
            ->post(route('notifications.mark-all-read'))
            ->assertRedirect();

        $this->assertSame(0, $mahasiswa->user->unreadNotifications()->count());
    }

    private function createDosen(BidangMinat $bidangMinat): Dosen
    {
        $user = User::factory()->create(['role' => 'dosen']);

        return Dosen::create([
            'user_id' => $user->id,
            'nip' => fake()->unique()->numerify('19##############'),
            'bidang_minat_id' => $bidangMinat->id,
        ]);
    }

    private function createMahasiswa(BidangMinat $bidangMinat): Mahasiswa
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);

        return Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => fake()->unique()->numerify('######'),
            'angkatan' => 2021,
            'bidang_minat_id' => $bidangMinat->id,
        ]);
    }
}
