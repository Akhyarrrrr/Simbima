<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BidangMinat;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function index(): View
    {
        $mahasiswas = Mahasiswa::query()
            ->with(['user', 'bidangMinat', 'bimbingan'])
            ->latest()
            ->get();

        return view('admin.mahasiswas.index', compact('mahasiswas'));
    }

    public function create(): View
    {
        $bidangMinats = BidangMinat::orderBy('nama')->get();

        return view('admin.mahasiswas.create', compact('bidangMinats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'mahasiswa',
            ]);

            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'angkatan' => $validated['angkatan'],
                'bidang_minat_id' => $validated['bidang_minat_id'],
            ]);
        });

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('status', 'Data mahasiswa berhasil dibuat.');
    }

    public function show(Mahasiswa $mahasiswa): View
    {
        $mahasiswa->load(['user', 'bidangMinat', 'pengajuanBimbingans.dosen.user', 'bimbingan']);

        return view('admin.mahasiswas.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        $mahasiswa->load(['user', 'bidangMinat']);
        $bidangMinats = BidangMinat::orderBy('nama')->get();

        return view('admin.mahasiswas.edit', compact('mahasiswa', 'bidangMinats'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $validated = $request->validate($this->rules($mahasiswa));

        DB::transaction(function () use ($mahasiswa, $validated) {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => 'mahasiswa',
            ];

            if (! empty($validated['password'])) {
                $userData['password'] = $validated['password'];
            }

            $mahasiswa->user->update($userData);

            $mahasiswa->update([
                'nim' => $validated['nim'],
                'angkatan' => $validated['angkatan'],
                'bidang_minat_id' => $validated['bidang_minat_id'],
            ]);
        });

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('status', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        DB::transaction(function () use ($mahasiswa) {
            $mahasiswa->user->delete();
        });

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('status', 'Data mahasiswa berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(?Mahasiswa $mahasiswa = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($mahasiswa?->user_id),
            ],
            'password' => [$mahasiswa ? 'nullable' : 'required', 'string', 'min:8'],
            'nim' => [
                'required',
                'string',
                'max:255',
                Rule::unique('mahasiswas', 'nim')->ignore($mahasiswa?->id),
            ],
            'angkatan' => ['required', 'integer', 'between:2000,2100'],
            'bidang_minat_id' => ['nullable', 'integer', Rule::exists('bidang_minats', 'id')],
        ];
    }
}
