<?php

namespace Tests\Feature;

use App\Models\BidangMinat;
use App\Models\Bimbingan;
use App\Models\CatatanBimbingan;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BimbinganProgressTest extends TestCase
{
    use RefreshDatabase;

    public function test_related_users_can_add_catatan_bimbingan(): void
    {
        [$mahasiswaUser, $dospem1User, $dospem2User, $bimbingan] = $this->makeBimbingan();

        foreach ([$mahasiswaUser, $dospem1User, $dospem2User] as $user) {
            $this->actingAs($user)
                ->post(route('bimbingan.catatan.store', $bimbingan), [
                    'kategori' => 'progress',
                    'isi' => 'Progress bimbingan terbaru.',
                ])
                ->assertRedirect();
        }

        $this->assertSame(3, CatatanBimbingan::count());
    }

    public function test_unrelated_user_can_not_add_catatan_bimbingan(): void
    {
        [, , , $bimbingan] = $this->makeBimbingan();
        $otherUser = User::factory()->create(['role' => 'mahasiswa']);

        $this->actingAs($otherUser)
            ->post(route('bimbingan.catatan.store', $bimbingan), [
                'kategori' => 'saran',
                'isi' => 'Tidak boleh masuk.',
            ])
            ->assertForbidden();
    }

    public function test_only_dospem1_can_update_readiness_status_in_order(): void
    {
        [, $dospem1User, $dospem2User, $bimbingan] = $this->makeBimbingan();

        $this->actingAs($dospem2User)
            ->patch(route('dosen.bimbingan.status.update', $bimbingan), [
                'boleh_sempro' => true,
            ])
            ->assertForbidden();

        $this->actingAs($dospem1User)
            ->patch(route('dosen.bimbingan.status.update', $bimbingan), [
                'boleh_semhas' => true,
            ])
            ->assertSessionHasErrors('boleh_semhas');

        $this->actingAs($dospem1User)
            ->patch(route('dosen.bimbingan.status.update', $bimbingan), [
                'boleh_sempro' => true,
                'boleh_semhas' => true,
                'boleh_sidang' => true,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('bimbingans', [
            'id' => $bimbingan->id,
            'boleh_sempro' => true,
            'boleh_semhas' => true,
            'boleh_sidang' => true,
        ]);
    }

    private function makeBimbingan(): array
    {
        $bidangMinat = BidangMinat::create(['nama' => 'Data Mining']);

        $mahasiswaUser = User::factory()->create(['role' => 'mahasiswa']);
        $dospem1User = User::factory()->create(['role' => 'dosen']);
        $dospem2User = User::factory()->create(['role' => 'dosen']);

        $mahasiswa = Mahasiswa::create([
            'user_id' => $mahasiswaUser->id,
            'nim' => '2108107010999',
            'angkatan' => 2021,
            'bidang_minat_id' => $bidangMinat->id,
        ]);

        $dospem1 = Dosen::create([
            'user_id' => $dospem1User->id,
            'nip' => '198001012010121001',
            'bidang_minat_id' => $bidangMinat->id,
        ]);

        $dospem2 = Dosen::create([
            'user_id' => $dospem2User->id,
            'nip' => '198001012010121002',
            'bidang_minat_id' => $bidangMinat->id,
        ]);

        $bimbingan = Bimbingan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'dospem1_id' => $dospem1->id,
            'dospem2_id' => $dospem2->id,
            'judul_ta' => 'Sistem Rekomendasi Bimbingan',
            'status' => 'aktif',
        ]);

        return [$mahasiswaUser, $dospem1User, $dospem2User, $bimbingan];
    }
}
