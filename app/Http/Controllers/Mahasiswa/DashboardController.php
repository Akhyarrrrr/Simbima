<?php

namespace App\Http\Controllers\Mahasiswa;

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
        $mahasiswa = Auth::user()
            ->mahasiswa()
            ->with('bidangMinat')
            ->firstOrFail();

        $dosens = Dosen::query()
            ->with(['user', 'bidangMinat'])
            ->where('bidang_minat_id', $mahasiswa->bidang_minat_id)
            ->orderBy('nip')
            ->get()
            ->map(function (Dosen $dosen) use ($mahasiswa) {
                $dosen->sisa_slot = $dosen->sisaSlot($mahasiswa->angkatan);

                return $dosen;
            });

        $allDosens = Dosen::query()
            ->with('user')
            ->orderBy('nip')
            ->get();

        $pengajuanAktif = PengajuanBimbingan::query()
            ->with('dosen.user')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        $bimbingan = Bimbingan::query()
            ->with(['dospem1.user', 'dospem2.user'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'aktif')
            ->first();

        $bimbinganProgres = Bimbingan::query()
            ->with(['dospem1.user', 'dospem2.user'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->first();

        $riwayatDitolak = PengajuanBimbingan::query()
            ->with('dosen.user')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'ditolak')
            ->latest()
            ->get();

        return view('mahasiswa.dashboard', compact('mahasiswa', 'dosens', 'allDosens', 'pengajuanAktif', 'bimbingan', 'bimbinganProgres', 'riwayatDitolak'));
    }
}
