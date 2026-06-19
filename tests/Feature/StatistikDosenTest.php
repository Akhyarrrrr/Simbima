<?php

namespace Tests\Feature;

use App\Models\BidangMinat;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatistikDosenTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_dosen_can_view_dosen_statistics(): void
    {
        $bidangMinat = BidangMinat::create(['nama' => 'Jaringan']);

        $dosenUser = User::factory()->create(['role' => 'dosen']);
        Dosen::create([
            'user_id' => $dosenUser->id,
            'nip' => '198001012010121001',
            'bidang_minat_id' => $bidangMinat->id,
        ]);

        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('statistik.dosen'))
            ->assertOk()
            ->assertSee('Beban Bimbingan Dosen');

        $this->actingAs($dosenUser)
            ->get(route('statistik.dosen'))
            ->assertOk()
            ->assertSee('Beban Bimbingan Dosen');
    }

    public function test_mahasiswa_can_not_view_dosen_statistics(): void
    {
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $this->actingAs($mahasiswa)
            ->get(route('statistik.dosen'))
            ->assertForbidden();
    }
}
