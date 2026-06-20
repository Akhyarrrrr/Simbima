<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BimbinganController extends Controller
{
    public function updateDospem2(Request $request, int $id): RedirectResponse
    {
        $bimbingan = Bimbingan::findOrFail($id);

        $validated = $request->validate([
            'dospem2_id' => ['nullable', 'integer', Rule::exists('dosens', 'id')],
        ]);

        if ((int) ($validated['dospem2_id'] ?? 0) === (int) $bimbingan->dospem1_id) {
            throw ValidationException::withMessages([
                'dospem2_id' => 'Dospem 2 harus berbeda dari dospem 1.',
            ]);
        }

        $bimbingan->update([
            'dospem2_id' => $validated['dospem2_id'] ?? null,
        ]);

        return back()->with('status', 'Dospem 2 berhasil diperbarui.');
    }
}
