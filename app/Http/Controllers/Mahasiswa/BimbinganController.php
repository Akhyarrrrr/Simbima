<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function update(Request $request, int $id): RedirectResponse
    {
        $mahasiswa = $request->user()->mahasiswa()->firstOrFail();

        $validated = $request->validate([
            'judul_ta' => ['nullable', 'string', 'max:255'],
        ]);

        $bimbingan = Bimbingan::query()
            ->where('id', $id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->firstOrFail();

        $bimbingan->update([
            'judul_ta' => $validated['judul_ta'] ?? null,
        ]);

        return redirect()
            ->route('mahasiswa.dashboard')
            ->with('status', 'Data bimbingan berhasil diperbarui.');
    }
}
