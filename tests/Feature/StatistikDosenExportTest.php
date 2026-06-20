<?php

namespace Tests\Feature;

use App\Models\BidangMinat;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatistikDosenExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_export_statistik_dosen_csv(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $bidangMinat = BidangMinat::create(['nama' => 'Data Mining']);
        $user = User::factory()->create(['name' => 'Dosen Export', 'role' => 'dosen']);

        Dosen::create([
            'user_id' => $user->id,
            'nip' => '197410011999031001',
            'bidang_minat_id' => $bidangMinat->id,
        ]);

        $response = $this
            ->actingAs($admin)
            ->get(route('statistik.dosen.export'));

        $response
            ->assertOk()
            ->assertDownload('statistik-dosen.csv');
    }
}
