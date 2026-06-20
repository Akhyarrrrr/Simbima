<?php

namespace Tests\Feature;

use App\Imports\MahasiswaImport;
use App\Models\BidangMinat;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MahasiswaImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_import_creates_mahasiswa_without_bidang_minat(): void
    {
        $import = new MahasiswaImport();

        $mahasiswa = $import->model([
            'nama' => 'Mahasiswa Import',
            'nim' => '210001',
            'email' => 'mahasiswa.import@simbima.test',
            'angkatan' => 2021,
        ]);

        $this->assertInstanceOf(Mahasiswa::class, $mahasiswa);
        $this->assertNull($mahasiswa->bidang_minat_id);
        $this->assertSame(1, $import->successCount);
        $this->assertCount(1, $import->credentials);
        $this->assertSame('Mahasiswa Import', $import->credentials[0]['nama']);
        $this->assertSame('mahasiswa.import@simbima.test', $import->credentials[0]['email']);
        $this->assertSame('210001', $import->credentials[0]['nim']);
        $this->assertSame(12, strlen($import->credentials[0]['plain_password']));
        $this->assertTrue(Hash::check($import->credentials[0]['plain_password'], $mahasiswa->user->password));
        $this->assertSame('mahasiswa', $mahasiswa->user->role);
    }

    public function test_mahasiswa_import_sets_valid_bidang_minat_when_provided(): void
    {
        $bidangMinat = BidangMinat::create(['nama' => 'Rekayasa Perangkat Lunak']);

        $import = new MahasiswaImport();

        $mahasiswa = $import->model([
            'nama' => 'Mahasiswa Import',
            'nim' => '210001',
            'email' => 'mahasiswa.import@simbima.test',
            'angkatan' => 2021,
            'bidang_minat' => 'rekayasa perangkat lunak',
        ]);

        $this->assertInstanceOf(Mahasiswa::class, $mahasiswa);
        $this->assertSame($bidangMinat->id, $mahasiswa->bidang_minat_id);
        $this->assertSame(1, $import->successCount);
    }

    public function test_mahasiswa_import_skips_unknown_bidang_minat_and_duplicates(): void
    {
        $bidangMinat = BidangMinat::create(['nama' => 'Data Mining']);

        User::factory()->create([
            'email' => 'existing@simbima.test',
            'role' => 'mahasiswa',
        ]);

        $existingUser = User::factory()->create(['role' => 'mahasiswa']);
        Mahasiswa::create([
            'user_id' => $existingUser->id,
            'nim' => '210099',
            'angkatan' => 2021,
            'bidang_minat_id' => $bidangMinat->id,
        ]);

        $import = new MahasiswaImport();

        $this->assertNull($import->model([
            'nama' => 'Unknown Bidang',
            'nim' => '210002',
            'email' => 'unknown@simbima.test',
            'angkatan' => 2021,
            'bidang_minat' => 'Tidak Ada',
        ]));

        $this->assertNull($import->model([
            'nama' => 'Duplicate Email',
            'nim' => '210003',
            'email' => 'existing@simbima.test',
            'angkatan' => 2021,
            'bidang_minat' => 'Data Mining',
        ]));

        $this->assertNull($import->model([
            'nama' => 'Duplicate NIM',
            'nim' => '210099',
            'email' => 'duplicate.nim@simbima.test',
            'angkatan' => 2021,
            'bidang_minat' => 'Data Mining',
        ]));

        $this->assertSame(0, $import->successCount);
        $this->assertCount(3, $import->skipped);
        $this->assertDatabaseMissing('users', ['email' => 'duplicate.nim@simbima.test']);
    }
}
