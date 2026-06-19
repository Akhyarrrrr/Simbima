<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    public function markSelesai(int $id): RedirectResponse
    {
        $dosen = Auth::user()->dosen()->firstOrFail();
        $bimbingan = Bimbingan::findOrFail($id);

        abort_unless((int) $bimbingan->dospem1_id === (int) $dosen->id, 403);

        $bimbingan->update([
            'status' => 'selesai',
        ]);

        return back()->with('status', 'Bimbingan berhasil ditandai selesai.');
    }
}
