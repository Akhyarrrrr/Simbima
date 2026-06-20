<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Dosen;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BimbinganDetailController extends Controller
{
    public function show(Request $request, int $id): View
    {
        $bimbingan = Bimbingan::query()
            ->with(['mahasiswa.user', 'mahasiswa.bidangMinat', 'dospem1.user', 'dospem2.user', 'catatans.user'])
            ->findOrFail($id);

        $user = $request->user();
        $canAccess = $user->role === 'admin'
            || $bimbingan->mahasiswa->user_id === $user->id
            || $bimbingan->dospem1->user_id === $user->id
            || $bimbingan->dospem2?->user_id === $user->id;

        abort_unless($canAccess, 403);

        $allDosens = Dosen::query()
            ->with('user')
            ->orderBy('nip')
            ->get();

        return view('bimbingan.show', compact('bimbingan', 'allDosens'));
    }
}
