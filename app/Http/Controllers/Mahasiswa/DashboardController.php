<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\BidangMinat;
use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\PengajuanBimbingan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $mahasiswa = Auth::user()
            ->mahasiswa()
            ->with('bidangMinat')
            ->firstOrFail();

        $bidangMinats = BidangMinat::query()
            ->withCount('dosens')
            ->orderBy('nama')
            ->get();

        $dosens = collect();

        if ($mahasiswa->bidang_minat_id) {
            $dosens = Dosen::query()
                ->with([
                    'user',
                    'bidangMinat',
                    'dosenSlots' => fn ($query) => $query->where('angkatan', $mahasiswa->angkatan),
                ])
                ->where('bidang_minat_id', $mahasiswa->bidang_minat_id)
                ->orderBy('nip')
                ->get()
                ->map(function (Dosen $dosen) use ($mahasiswa) {
                    $dosen->sisa_slot = $dosen->sisaSlot($mahasiswa->angkatan);

                    return $dosen;
                });
        }

        $pengajuanAktif = PengajuanBimbingan::query()
            ->with('dosen.user')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        $bimbingan = Bimbingan::query()
            ->with(['dospem1.user', 'dospem2.user', 'catatans.user'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'aktif')
            ->first();

        $bimbinganProgres = Bimbingan::query()
            ->with(['dospem1.user', 'dospem2.user', 'catatans.user'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->first();

        $riwayatDitolak = PengajuanBimbingan::query()
            ->with('dosen.user')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'ditolak')
            ->latest()
            ->get();

        return view('mahasiswa.dashboard', compact('mahasiswa', 'bidangMinats', 'dosens', 'pengajuanAktif', 'bimbingan', 'bimbinganProgres', 'riwayatDitolak'));
    }
}
