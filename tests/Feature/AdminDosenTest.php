<?php

namespace Tests\Feature;

use App\Models\BidangMinat;
use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDosenTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_not_delete_dosen_with_bimbingan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $bidangMinat = BidangMinat::create(['nama' => 'Data Mining']);
        $dosen = $this->createDosen($bidangMinat);
        $mahasiswa = $this->createMahasiswa($bidangMinat);

        Bimbingan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'dospem1_id' => $dosen->id,
            'status' => 'aktif',
        ]);

        $response = $this
            ->actingAs($admin)
            ->delete(route('admin.dosen.destroy', $dosen));

        $response->assertSessionHasErrors('dosen');
        $this->assertDatabaseHas('dosens', ['id' => $dosen->id]);
        $this->assertDatabaseHas('users', ['id' => $dosen->user_id]);
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
