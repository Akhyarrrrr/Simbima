<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\PengajuanBimbingan;
use App\Notifications\PengajuanBaru;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PengajuanController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dosen_id' => ['required', 'integer', 'exists:dosens,id'],
        ]);

        $mahasiswa = $request->user()->mahasiswa()->firstOrFail();
        $dosen = Dosen::findOrFail($validated['dosen_id']);

        if ($mahasiswa->pengajuanBimbingans()->where('status', 'pending')->exists()) {
            throw ValidationException::withMessages([
                'dosen_id' => 'Anda masih memiliki pengajuan bimbingan yang menunggu persetujuan.',
            ]);
        }

        if ($mahasiswa->bimbingan()->exists()) {
            throw ValidationException::withMessages([
                'dosen_id' => 'Anda sudah memiliki data bimbingan.',
            ]);
        }

        if ($dosen->bidang_minat_id !== $mahasiswa->bidang_minat_id) {
            throw ValidationException::withMessages([
                'dosen_id' => 'Dosen harus berasal dari bidang minat yang sama.',
            ]);
        }

        if ($dosen->sisaSlot($mahasiswa->angkatan) <= 0) {
            throw ValidationException::withMessages([
                'dosen_id' => 'Slot dosen untuk angkatan Anda sudah penuh.',
            ]);
        }

        $pengajuan = PengajuanBimbingan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'dosen_id' => $dosen->id,
            'status' => 'pending',
        ]);

        $pengajuan->load(['mahasiswa.user', 'dosen.user']);
        $dosen->user->notify(new PengajuanBaru($pengajuan));

        return redirect()
            ->route('mahasiswa.dashboard')
            ->with('status', 'Pengajuan bimbingan berhasil dikirim.');
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        $mahasiswa = $request->user()->mahasiswa()->firstOrFail();

        $pengajuan = PengajuanBimbingan::query()
            ->where('id', $id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $pengajuan->delete();

        return redirect()
            ->route('mahasiswa.dashboard')
            ->with('status', 'Pengajuan bimbingan berhasil dibatalkan.');
    }
}
