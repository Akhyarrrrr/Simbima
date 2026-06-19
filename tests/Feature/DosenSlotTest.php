<?php

namespace Tests\Feature;

use App\Models\BidangMinat;
use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\DosenSlot;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DosenSlotTest extends TestCase
{
    use RefreshDatabase;

    public function test_sisa_slot_only_counts_active_dospem1_bimbingans_for_matching_angkatan(): void
    {
        $bidangMinat = BidangMinat::create(['nama' => 'Rekayasa Perangkat Lunak']);
        $dosen = $this->createDosen($bidangMinat);
        $dosenKedua = $this->createDosen($bidangMinat);

        DosenSlot::create([
            'dosen_id' => $dosen->id,
            'angkatan' => 2022,
            'max_slot' => 3,
        ]);

        $mahasiswaDospem1 = $this->createMahasiswa($bidangMinat, 2022);
        $mahasiswaDospem2 = $this->createMahasiswa($bidangMinat, 2022);
        $mahasiswaSelesai = $this->createMahasiswa($bidangMinat, 2022);
        $mahasiswaAngkatanLain = $this->createMahasiswa($bidangMinat, 2021);

        Bimbingan::create([
            'mahasiswa_id' => $mahasiswaDospem1->id,
            'dospem1_id' => $dosen->id,
            'dospem2_id' => $dosenKedua->id,
            'status' => 'aktif',
        ]);

        Bimbingan::create([
            'mahasiswa_id' => $mahasiswaDospem2->id,
            'dospem1_id' => $dosenKedua->id,
            'dospem2_id' => $dosen->id,
            'status' => 'aktif',
        ]);

        Bimbingan::create([
            'mahasiswa_id' => $mahasiswaSelesai->id,
            'dospem1_id' => $dosen->id,
            'status' => 'selesai',
        ]);

        Bimbingan::create([
            'mahasiswa_id' => $mahasiswaAngkatanLain->id,
            'dospem1_id' => $dosen->id,
            'status' => 'aktif',
        ]);

        $this->assertSame(2, $dosen->sisaSlot(2022));
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

    private function createMahasiswa(BidangMinat $bidangMinat, int $angkatan): Mahasiswa
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);

        return Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => fake()->unique()->numerify('######'),
            'angkatan' => $angkatan,
            'bidang_minat_id' => $bidangMinat->id,
        ]);
    }
}
