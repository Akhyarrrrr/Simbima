<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\PengajuanBimbingan;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_mahasiswa' => Mahasiswa::count(),
            'total_dosen' => Dosen::count(),
            'bimbingan_aktif' => Bimbingan::where('status', 'aktif')->count(),
            'pending_pengajuan' => PengajuanBimbingan::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
