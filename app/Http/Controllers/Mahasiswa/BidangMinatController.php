<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BidangMinatController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bidang_minat_id' => ['required', 'integer', Rule::exists('bidang_minats', 'id')],
        ]);

        $mahasiswa = $request->user()->mahasiswa()->firstOrFail();

        if ($mahasiswa->pengajuanBimbingans()->where('status', 'pending')->exists() || $mahasiswa->bimbingan()->exists()) {
            return back()->withErrors([
                'bidang_minat_id' => 'Bidang minat tidak dapat diubah setelah ada pengajuan atau bimbingan.',
            ]);
        }

        $mahasiswa->update([
            'bidang_minat_id' => $validated['bidang_minat_id'],
        ]);

        return redirect()
            ->route('mahasiswa.dashboard')
            ->with('status', 'Bidang minat berhasil dipilih. Silakan pilih calon dosen pembimbing.');
    }
}
