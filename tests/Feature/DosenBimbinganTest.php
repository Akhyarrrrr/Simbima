<?php

namespace Tests\Feature;

use App\Models\BidangMinat;
use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DosenBimbinganTest extends TestCase
{
    use RefreshDatabase;

    public function test_dospem1_can_not_mark_bimbingan_as_selesai_before_sidang_ready(): void
    {
        $bidangMinat = BidangMinat::create(['nama' => 'Rekayasa Perangkat Lunak']);
        $dospem1 = $this->createDosen($bidangMinat);
        $mahasiswa = $this->createMahasiswa($bidangMinat);

        $bimbingan = Bimbingan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'dospem1_id' => $dospem1->id,
            'status' => 'aktif',
        ]);

        $response = $this
            ->actingAs($dospem1->user)
            ->patch(route('dosen.bimbingan.selesai', $bimbingan));

        $response->assertSessionHasErrors('bimbingan');

        $this->assertSame('aktif', $bimbingan->refresh()->status);
    }

    public function test_dospem1_can_mark_bimbingan_as_selesai_after_sidang_ready(): void
    {
        $bidangMinat = BidangMinat::create(['nama' => 'Rekayasa Perangkat Lunak']);
        $dospem1 = $this->createDosen($bidangMinat);
        $mahasiswa = $this->createMahasiswa($bidangMinat);

        $bimbingan = Bimbingan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'dospem1_id' => $dospem1->id,
            'boleh_sidang' => true,
            'status' => 'aktif',
        ]);

        $response = $this
            ->actingAs($dospem1->user)
            ->patch(route('dosen.bimbingan.selesai', $bimbingan));

        $response
            ->assertRedirect()
            ->assertSessionHas('status', 'Bimbingan berhasil ditandai selesai.');

        $this->assertSame('selesai', $bimbingan->refresh()->status);
    }

    public function test_dospem2_can_not_mark_bimbingan_as_selesai(): void
    {
        $bidangMinat = BidangMinat::create(['nama' => 'Data Mining']);
        $dospem1 = $this->createDosen($bidangMinat);
        $dospem2 = $this->createDosen($bidangMinat);
        $mahasiswa = $this->createMahasiswa($bidangMinat);

        $bimbingan = Bimbingan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'dospem1_id' => $dospem1->id,
            'dospem2_id' => $dospem2->id,
            'status' => 'aktif',
        ]);

        $response = $this
            ->actingAs($dospem2->user)
            ->patch(route('dosen.bimbingan.selesai', $bimbingan));

        $response->assertForbidden();

        $this->assertSame('aktif', $bimbingan->refresh()->status);
    }

    public function test_dospem1_can_assign_dospem2(): void
    {
        $bidangMinat = BidangMinat::create(['nama' => 'Data Mining']);
        $dospem1 = $this->createDosen($bidangMinat);
        $dospem2 = $this->createDosen($bidangMinat);
        $mahasiswa = $this->createMahasiswa($bidangMinat);

        $bimbingan = Bimbingan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'dospem1_id' => $dospem1->id,
            'status' => 'aktif',
        ]);

        $response = $this
            ->actingAs($dospem1->user)
            ->patch(route('dosen.bimbingan.dospem2.update', $bimbingan), [
                'dospem2_id' => $dospem2->id,
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('status', 'Dospem 2 berhasil diperbarui.');

        $this->assertSame($dospem2->id, $bimbingan->refresh()->dospem2_id);
    }

    public function test_mahasiswa_can_not_update_dospem2(): void
    {
        $bidangMinat = BidangMinat::create(['nama' => 'Data Mining']);
        $dospem1 = $this->createDosen($bidangMinat);
        $dospem2 = $this->createDosen($bidangMinat);
        $mahasiswa = $this->createMahasiswa($bidangMinat);

        $bimbingan = Bimbingan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'dospem1_id' => $dospem1->id,
            'status' => 'aktif',
        ]);

        $response = $this
            ->actingAs($mahasiswa->user)
            ->patch(route('mahasiswa.bimbingan.update', $bimbingan), [
                'judul_ta' => 'Judul Baru',
                'dospem2_id' => $dospem2->id,
            ]);

        $response->assertRedirect(route('mahasiswa.dashboard'));

        $bimbingan->refresh();
        $this->assertSame('Judul Baru', $bimbingan->judul_ta);
        $this->assertNull($bimbingan->dospem2_id);
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
