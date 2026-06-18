<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): RedirectResponse
    {
        return match (Auth::user()->role) {
            'mahasiswa' => redirect('/mahasiswa/dashboard'),
            'dosen' => redirect('/dosen/dashboard'),
            'admin' => redirect('/admin/dashboard'),
            default => abort(403),
        };
    }
}
