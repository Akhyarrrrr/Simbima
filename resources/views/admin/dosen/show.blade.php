@section('eyebrow', 'DETAIL DOSEN')
@section('title', $dosen->user->name)

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
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Profil Dosen</p>
                <h3 class="mt-1 font-display text-lg font-semibold text-navy">Data Dosen</h3>
            </div>

            <dl class="grid gap-5 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Nama</dt>
                    <dd class="mt-1 text-sm font-medium text-navy">{{ $dosen->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Email</dt>
                    <dd class="mt-1 text-sm font-medium text-navy">{{ $dosen->user->email }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">NIP</dt>
                    <dd class="mt-1 font-mono text-sm font-medium text-navy">{{ $dosen->nip }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Bidang Minat</dt>
                    <dd class="mt-1 text-sm font-medium text-navy">{{ $dosen->bidangMinat->nama }}</dd>
                </div>
            </dl>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5 border-b border-gold/30 pb-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Keamanan</p>
                <h3 class="mt-1 font-display text-lg font-semibold text-navy">Reset Password</h3>
                <p class="mt-1 text-sm text-slate">Gunakan saat dosen lupa password. Bagikan password baru secara langsung kepada dosen.</p>
            </div>

            <form method="POST" action="{{ route('admin.users.password.update', $dosen->user) }}" class="grid gap-4 sm:grid-cols-2">
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
            <a class="inline-flex items-center rounded-md border border-navy px-4 py-2 text-sm font-semibold text-navy transition-colors hover:bg-navy hover:text-white focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2" href="{{ route('admin.dosen.index') }}">
                Kembali
            </a>
        </div>
    </div>
</x-app-layout>
