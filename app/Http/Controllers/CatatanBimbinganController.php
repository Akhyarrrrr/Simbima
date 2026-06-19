<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CatatanBimbinganController extends Controller
{
    public function store(Request $request, int $bimbinganId): RedirectResponse
    {
        $validated = $request->validate([
            'kategori' => ['required', 'string', Rule::in(['revisi', 'saran', 'progress'])],
            'isi' => ['required', 'string', 'max:2000'],
        ]);

        $bimbingan = Bimbingan::query()
            ->with(['mahasiswa.user', 'dospem1.user', 'dospem2.user'])
            ->findOrFail($bimbinganId);

        abort_unless($this->canAccess($request, $bimbingan), 403);

        $bimbingan->catatans()->create([
            'user_id' => $request->user()->id,
            'kategori' => $validated['kategori'],
            'isi' => $validated['isi'],
        ]);

        return back()->with('status', 'Catatan bimbingan berhasil ditambahkan.');
    }

    private function canAccess(Request $request, Bimbingan $bimbingan): bool
    {
        $userId = $request->user()->id;

        return $bimbingan->mahasiswa->user_id === $userId
            || $bimbingan->dospem1->user_id === $userId
            || $bimbingan->dospem2?->user_id === $userId;
    }
}
