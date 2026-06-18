<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BidangMinat;
use App\Models\Dosen;
use App\Models\DosenSlot;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DosenController extends Controller
{
    public function index(): View
    {
        $dosens = Dosen::query()
            ->with(['user', 'bidangMinat', 'dosenSlots'])
            ->latest()
            ->get();

        return view('admin.dosen.index', compact('dosens'));
    }

    public function create(): View
    {
        $bidangMinats = BidangMinat::orderBy('nama')->get();

        return view('admin.dosen.create', compact('bidangMinats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'dosen',
            ]);

            $dosen = Dosen::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'bidang_minat_id' => $validated['bidang_minat_id'],
            ]);

            DosenSlot::create([
                'dosen_id' => $dosen->id,
                'angkatan' => $validated['angkatan'],
                'max_slot' => $validated['max_slot'],
            ]);
        });

        return redirect()
            ->route('admin.dosen.index')
            ->with('status', 'Data dosen berhasil dibuat.');
    }

    public function show(Dosen $dosen): View
    {
        $dosen->load(['user', 'bidangMinat', 'dosenSlots']);

        return view('admin.dosen.show', compact('dosen'));
    }

    public function edit(Dosen $dosen): View
    {
        $dosen->load(['user', 'bidangMinat', 'dosenSlots']);
        $bidangMinats = BidangMinat::orderBy('nama')->get();

        return view('admin.dosen.edit', compact('dosen', 'bidangMinats'));
    }

    public function update(Request $request, Dosen $dosen): RedirectResponse
    {
        $validated = $request->validate($this->rules($dosen));

        DB::transaction(function () use ($dosen, $validated) {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => 'dosen',
            ];

            if (! empty($validated['password'])) {
                $userData['password'] = $validated['password'];
            }

            $dosen->user->update($userData);

            $dosen->update([
                'nip' => $validated['nip'],
                'bidang_minat_id' => $validated['bidang_minat_id'],
            ]);

            DosenSlot::updateOrCreate(
                [
                    'dosen_id' => $dosen->id,
                    'angkatan' => $validated['angkatan'],
                ],
                ['max_slot' => $validated['max_slot']],
            );
        });

        return redirect()
            ->route('admin.dosen.index')
            ->with('status', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen): RedirectResponse
    {
        DB::transaction(function () use ($dosen) {
            $dosen->user->delete();
        });

        return redirect()
            ->route('admin.dosen.index')
            ->with('status', 'Data dosen berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(?Dosen $dosen = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($dosen?->user_id),
            ],
            'password' => [$dosen ? 'nullable' : 'required', 'string', 'min:8'],
            'nip' => [
                'required',
                'string',
                'max:255',
                Rule::unique('dosens', 'nip')->ignore($dosen?->id),
            ],
            'bidang_minat_id' => ['required', 'integer', Rule::exists('bidang_minats', 'id')],
            'angkatan' => ['required', 'integer', 'between:2000,2100'],
            'max_slot' => ['required', 'integer', 'between:0,255'],
        ];
    }
}
