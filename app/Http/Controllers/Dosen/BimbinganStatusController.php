<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BimbinganStatusController extends Controller
{
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'boleh_sempro' => ['sometimes', 'boolean'],
            'boleh_semhas' => ['sometimes', 'boolean'],
            'boleh_sidang' => ['sometimes', 'boolean'],
        ]);

        $dosen = $request->user()->dosen()->firstOrFail();
        $bimbingan = Bimbingan::findOrFail($id);

        abort_unless($bimbingan->dospem1_id === $dosen->id, 403);

        $nextState = [
            'boleh_sempro' => (bool) $bimbingan->boleh_sempro,
            'boleh_semhas' => (bool) $bimbingan->boleh_semhas,
            'boleh_sidang' => (bool) $bimbingan->boleh_sidang,
        ];

        foreach (array_keys($nextState) as $field) {
            if (array_key_exists($field, $validated)) {
                $nextState[$field] = (bool) $validated[$field];
            }
        }

        if ($nextState['boleh_semhas'] && ! $nextState['boleh_sempro']) {
            throw ValidationException::withMessages([
                'boleh_semhas' => 'Semhas hanya dapat diizinkan setelah Sempro diizinkan.',
            ]);
        }

        if ($nextState['boleh_sidang'] && ! $nextState['boleh_semhas']) {
            throw ValidationException::withMessages([
                'boleh_sidang' => 'Sidang hanya dapat diizinkan setelah Semhas diizinkan.',
            ]);
        }

        $bimbingan->update($nextState);

        return back()->with('status', 'Status kesiapan bimbingan berhasil diperbarui.');
    }
}
