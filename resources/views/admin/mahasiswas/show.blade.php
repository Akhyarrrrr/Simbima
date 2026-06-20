@section('eyebrow', 'DETAIL MAHASISWA')
@section('title', $mahasiswa->user->name)

<x-app-layout>
    <div class="max-w-3xl space-y-6">
        @if (session('status'))
            <div class="rounded-md border border-forest/20 bg-forest/10 px-4 py-3 text-sm font-medium text-forest">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-md border border-rust/20 bg-rust/10 px-4 py-3 text-sm font-medium text-rust">
                {{ $errors->first() }}
            </div>
        @endif

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5 border-b border-gold/30 pb-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Profil Akademik</p>
                <h3 class="mt-1 font-display text-lg font-semibold text-navy">Data Mahasiswa</h3>
            </div>

            <dl class="grid gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Nama</dt>
                    <dd class="mt-1 text-sm font-medium text-navy">{{ $mahasiswa->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Email</dt>
                    <dd class="mt-1 text-sm font-medium text-navy">{{ $mahasiswa->user->email }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">NIM</dt>
                    <dd class="mt-1 font-mono text-sm font-medium text-navy">{{ $mahasiswa->nim }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Angkatan</dt>
                    <dd class="mt-1 text-sm font-medium text-navy">{{ $mahasiswa->angkatan }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Bidang Minat</dt>
                    <dd class="mt-1 text-sm font-medium text-navy">{{ $mahasiswa->bidangMinat?->nama ?? 'Belum dipilih mahasiswa' }}</dd>
                </div>
            </dl>
        </section>

        @if ($mahasiswa->bimbingan)
            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-5 border-b border-gold/30 pb-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate">Bimbingan</p>
                    <h3 class="mt-1 font-display text-lg font-semibold text-navy">Pembimbing Tugas Akhir</h3>
                </div>

                <dl class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Dospem 1</dt>
                        <dd class="mt-1 text-sm font-medium text-navy">{{ $mahasiswa->bimbingan->dospem1->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Dospem 2 Saat Ini</dt>
                        <dd class="mt-1 text-sm font-medium text-navy">{{ $mahasiswa->bimbingan->dospem2?->user?->name ?? 'Belum ditentukan' }}</dd>
                    </div>
                </dl>

                <form method="POST" action="{{ route('admin.bimbingan.dospem2.update', $mahasiswa->bimbingan) }}" class="mt-5 border-t border-slate-100 pt-5">
                    @csrf
                    @method('PATCH')

                    <x-input-label for="dospem2_id" value="Atur Dospem 2" class="text-slate" />
                    <select id="dospem2_id" name="dospem2_id" class="mt-1 block h-10 w-full rounded-md border-slate-300 text-sm text-navy shadow-sm focus:border-navy focus:ring-navy">
                        <option value="">Belum ditentukan</option>
                        @foreach ($dosens as $dosen)
                            @if ($dosen->id !== $mahasiswa->bimbingan->dospem1_id)
                                <option value="{{ $dosen->id }}" @selected(old('dospem2_id', $mahasiswa->bimbingan->dospem2_id) == $dosen->id)>
                                    {{ $dosen->user->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>

                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="inline-flex h-10 items-center rounded-md bg-navy px-4 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                            Simpan Dospem 2
                        </button>
                    </div>
                </form>
            </section>
        @endif

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5 border-b border-gold/30 pb-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Keamanan</p>
                <h3 class="mt-1 font-display text-lg font-semibold text-navy">Reset Password</h3>
                <p class="mt-1 text-sm text-slate">Gunakan saat mahasiswa lupa password. Bagikan password baru secara langsung kepada mahasiswa.</p>
            </div>

            <form method="POST" action="{{ route('admin.users.password.update', $mahasiswa->user) }}" class="grid gap-4 sm:grid-cols-2">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="password" value="Password Baru" class="text-xs font-semibold uppercase tracking-wide text-slate" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full rounded-md border-slate-300 text-sm text-navy shadow-sm focus:border-navy focus:ring-navy" required autocomplete="new-password" />
                </div>
                <div>
                    <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-xs font-semibold uppercase tracking-wide text-slate" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-md border-slate-300 text-sm text-navy shadow-sm focus:border-navy focus:ring-navy" required autocomplete="new-password" />
                </div>
                <div class="sm:col-span-2 flex justify-end">
                    <button type="submit" class="inline-flex h-10 items-center rounded-md bg-navy px-4 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                        Reset Password
                    </button>
                </div>
            </form>
        </section>

        <div>
            <a class="inline-flex items-center rounded-md border border-navy px-4 py-2 text-sm font-semibold text-navy transition-colors hover:bg-navy hover:text-white focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2" href="{{ route('admin.mahasiswa.index') }}">
                Kembali
            </a>
        </div>
    </div>
</x-app-layout>
