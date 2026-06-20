<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\PengajuanBimbingan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $dosen = Auth::user()->dosen()->firstOrFail();

        $pendingPengajuans = PengajuanBimbingan::query()
            ->with(['mahasiswa.user', 'mahasiswa.bidangMinat'])
            ->where('dosen_id', $dosen->id)
            ->where('status', 'pending')
            ->latest()
            ->get();

        $activeBimbingans = Bimbingan::query()
            ->with(['mahasiswa.user', 'dospem1.user', 'dospem2.user', 'catatans.user'])
            ->where('status', 'aktif')
            ->where(function ($query) use ($dosen) {
                $query->where('dospem1_id', $dosen->id)
                    ->orWhere('dospem2_id', $dosen->id);
            })
            ->latest()
            ->get();

        $allDosens = Dosen::query()
            ->with('user')
            ->orderBy('nip')
            ->get();

        return view('dosen.dashboard', compact('dosen', 'pendingPengajuans', 'activeBimbingans', 'allDosens'));
    }
}
