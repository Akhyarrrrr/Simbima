<?php

namespace Database\Seeders;

use App\Models\BidangMinat;
use App\Models\Dosen;
use App\Models\DosenSlot;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $bidangMinats = collect([
            'Rekayasa Perangkat Lunak',
            'Data Mining',
            'Sistem Informasi Geografis',
            'Jaringan',
        ])->mapWithKeys(function (string $nama) {
            $bidangMinat = BidangMinat::firstOrCreate(['nama' => $nama]);

            return [$nama => $bidangMinat];
        });

        User::updateOrCreate(
            ['email' => 'admin@simbima.test'],
            [
                'name' => 'Admin Simbima',
                'password' => 'password',
                'role' => 'admin',
            ],
        );

        $dosenData = [
            ['name' => 'Dosen RPL', 'email' => 'dosen.rpl@simbima.test', 'bidang_minat' => 'Rekayasa Perangkat Lunak'],
            ['name' => 'Dosen Data Mining', 'email' => 'dosen.data-mining@simbima.test', 'bidang_minat' => 'Data Mining'],
            ['name' => 'Dosen SIG', 'email' => 'dosen.sig@simbima.test', 'bidang_minat' => 'Sistem Informasi Geografis'],
            ['name' => 'Dosen Jaringan', 'email' => 'dosen.jaringan@simbima.test', 'bidang_minat' => 'Jaringan'],
        ];

        foreach ($dosenData as $index => $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => 'password',
                    'role' => 'dosen',
                ],
            );

            $dosen = Dosen::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip' => $this->generateNip($index + 1),
                    'bidang_minat_id' => $bidangMinats[$data['bidang_minat']]->id,
                ],
            );

            DosenSlot::updateOrCreate(
                [
                    'dosen_id' => $dosen->id,
                    'angkatan' => 2021,
                ],
                ['max_slot' => 10],
            );
        }

        $mahasiswaData = [
            ['name' => 'Mahasiswa RPL', 'email' => 'mahasiswa.rpl@simbima.test', 'nim' => '202101001', 'bidang_minat' => 'Rekayasa Perangkat Lunak'],
            ['name' => 'Mahasiswa Data Mining', 'email' => 'mahasiswa.data-mining@simbima.test', 'nim' => '202101002', 'bidang_minat' => 'Data Mining'],
            ['name' => 'Mahasiswa SIG', 'email' => 'mahasiswa.sig@simbima.test', 'nim' => '202101003', 'bidang_minat' => 'Sistem Informasi Geografis'],
        ];

        foreach ($mahasiswaData as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => 'password',
                    'role' => 'mahasiswa',
                ],
            );

            Mahasiswa::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nim' => $data['nim'],
                    'angkatan' => 2021,
                    'bidang_minat_id' => $bidangMinats[$data['bidang_minat']]->id,
                ],
            );
        }
    }

    private function generateNip(int $sequence): string
    {
        return sprintf('198001012021011%03d', $sequence);
    }
}
