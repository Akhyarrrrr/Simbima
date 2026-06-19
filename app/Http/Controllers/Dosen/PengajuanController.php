<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\PengajuanBimbingan;
use App\Notifications\PengajuanDiterima;
use App\Notifications\PengajuanDitolak;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PengajuanController extends Controller
{
    public function approve(Request $request, int $id): RedirectResponse
    {
        $dosen = $request->user()->dosen()->firstOrFail();

        $pengajuan = DB::transaction(function () use ($dosen, $id) {
            $pengajuan = PengajuanBimbingan::query()
                ->with(['mahasiswa.user', 'dosen.user'])
                ->where('id', $id)
                ->where('dosen_id', $dosen->id)
                ->where('status', 'pending')
                ->lockForUpdate()
                ->firstOrFail();

            if ($pengajuan->mahasiswa->bimbingan()->exists()) {
                throw ValidationException::withMessages([
                    'pengajuan' => 'Mahasiswa sudah memiliki data bimbingan.',
                ]);
            }

            if ($dosen->sisaSlot($pengajuan->mahasiswa->angkatan) <= 0) {
                throw ValidationException::withMessages([
                    'pengajuan' => 'Slot bimbingan dosen untuk angkatan ini sudah penuh.',
                ]);
            }

            $pengajuan->update([
                'status' => 'diterima',
                'catatan_penolakan' => null,
            ]);

            Bimbingan::create([
                'mahasiswa_id' => $pengajuan->mahasiswa_id,
                'dospem1_id' => $dosen->id,
                'status' => 'aktif',
            ]);

            return $pengajuan;
        });

        $pengajuan->mahasiswa->user->notify(new PengajuanDiterima($pengajuan));

        return redirect()
            ->route('dosen.dashboard')
            ->with('status', 'Pengajuan bimbingan berhasil diterima.');
    }

    public function reject(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'catatan_penolakan' => ['required', 'string'],
        ]);

        $dosen = $request->user()->dosen()->firstOrFail();

        $pengajuan = PengajuanBimbingan::query()
            ->with(['mahasiswa.user', 'dosen.user'])
            ->where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $pengajuan->update([
            'status' => 'ditolak',
            'catatan_penolakan' => $validated['catatan_penolakan'],
        ]);

        $pengajuan->mahasiswa->user->notify(new PengajuanDitolak($pengajuan));

        return redirect()
            ->route('dosen.dashboard')
            ->with('status', 'Pengajuan bimbingan berhasil ditolak.');
    }
}
