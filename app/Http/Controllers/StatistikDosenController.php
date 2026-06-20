<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class StatistikDosenController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(in_array($request->user()->role, ['admin', 'dosen'], true), 403);

        $dosens = $this->rows();

        $stats = [
            'total_dosen' => $dosens->count(),
            'total_bimbingan_aktif' => $dosens->sum('bimbingan_aktif_count'),
            'rata_rata_beban' => $dosens->count() > 0
                ? round($dosens->sum('bimbingan_aktif_count') / $dosens->count(), 1)
                : 0,
        ];

        $chartData = [
            'labels' => $dosens->pluck('nama'),
            'values' => $dosens->pluck('bimbingan_aktif_count'),
            'colors' => $dosens->map(fn (array $dosen) => $dosen['status'] === 'Overload' ? '#9A3B3B' : '#1B2A4A')->values(),
        ];

        return view('statistik.dosen', compact('dosens', 'stats', 'chartData'));
    }

    public function export(Request $request)
    {
        abort_unless(in_array($request->user()->role, ['admin', 'dosen'], true), 403);

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['nama', 'nip', 'bidang_minat', 'angkatan_slot', 'bimbingan_aktif', 'max_slot', 'status']);

            foreach ($this->rows() as $row) {
                fputcsv($handle, [
                    $row['nama'],
                    $row['nip'],
                    $row['bidang_minat'],
                    $row['angkatan_slot'],
                    $row['bimbingan_aktif_count'],
                    $row['max_slot'],
                    $row['status'],
                ]);
            }

            fclose($handle);
        }, 'statistik-dosen.csv', ['Content-Type' => 'text/csv']);
    }

    private function rows()
    {
        return Dosen::query()
            ->with(['user', 'bidangMinat', 'dosenSlots' => fn ($query) => $query->orderByDesc('angkatan')])
            ->withCount([
                'bimbingansDospem1 as bimbingan_aktif_count' => fn ($query) => $query->where('status', 'aktif'),
            ])
            ->get()
            ->sortBy([
                ['bidangMinat.nama', 'asc'],
                ['bimbingan_aktif_count', 'desc'],
                ['user.name', 'asc'],
            ])
            ->values()
            ->map(function (Dosen $dosen) {
                $slot = $dosen->dosenSlots->first();
                $maxSlot = $slot?->max_slot ?? 0;
                $count = (int) $dosen->bimbingan_aktif_count;

                $status = match (true) {
                    $maxSlot > 0 && $count > $maxSlot => 'Overload',
                    $maxSlot > 0 && $count === $maxSlot => 'Penuh',
                    default => 'Tersedia',
                };

                return [
                    'id' => $dosen->id,
                    'nama' => $dosen->user->name,
                    'nip' => $dosen->nip,
                    'bidang_minat' => $dosen->bidangMinat->nama,
                    'angkatan_slot' => $slot?->angkatan ?? 2021,
                    'max_slot' => $maxSlot,
                    'bimbingan_aktif_count' => $count,
                    'status' => $status,
                ];
            });
    }
}
