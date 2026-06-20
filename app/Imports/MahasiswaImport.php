<?php

namespace App\Imports;

use App\Models\BidangMinat;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
     * @var array<int, array{nama: string, email: string, nim: string, plain_password: string}>
     */
    public array $credentials = [];

    /**
     * @var array<int, array{row: int, reason: string}>
     */
    public array $skipped = [];

    public int $successCount = 0;

    private int $currentRow = 1;

    /**
     * @param  array<string, mixed>  $row
     */
    public function model(array $row): ?Mahasiswa
    {
        $this->currentRow++;

        $nama = trim((string) ($row['nama'] ?? ''));
        $nim = trim((string) ($row['nim'] ?? ''));
        $email = Str::lower(trim((string) ($row['email'] ?? '')));
        $angkatan = trim((string) ($row['angkatan'] ?? ''));
        $bidangMinatName = trim((string) ($row['bidang_minat'] ?? ''));

        if ($nama === '' || $nim === '' || $email === '' || $angkatan === '') {
            $this->skip('Kolom wajib tidak lengkap.');

            return null;
        }

        $bidangMinat = null;

        if ($bidangMinatName !== '') {
            $bidangMinat = BidangMinat::query()
                ->whereRaw('LOWER(nama) = ?', [Str::lower($bidangMinatName)])
                ->first();

            if (! $bidangMinat) {
                $this->skip("Bidang minat '{$bidangMinatName}' tidak ditemukan.");

                return null;
            }
        }

        $plainPassword = Str::random(12);

        try {
            /** @var Mahasiswa $mahasiswa */
            $mahasiswa = DB::transaction(function () use ($nama, $nim, $email, $angkatan, $bidangMinat, $plainPassword) {
                $user = User::create([
                    'name' => $nama,
                    'email' => $email,
                    'password' => Hash::make($plainPassword),
                    'role' => 'mahasiswa',
                ]);

                return Mahasiswa::create([
                    'user_id' => $user->id,
                    'nim' => $nim,
                    'angkatan' => (int) $angkatan,
                    'bidang_minat_id' => $bidangMinat?->id,
                ]);
            });
        } catch (QueryException $exception) {
            $this->skip('Email atau NIM sudah terdaftar.');

            return null;
        } catch (Throwable $exception) {
            $this->skip('Gagal mengimpor baris: '.$exception->getMessage());

            return null;
        }

        $this->successCount++;
        $this->credentials[] = [
            'nama' => $nama,
            'email' => $email,
            'nim' => $nim,
            'plain_password' => $plainPassword,
        ];

        return $mahasiswa;
    }

    private function skip(string $reason): void
    {
        $this->skipped[] = [
            'row' => $this->currentRow,
            'reason' => $reason,
        ];
    }
}
