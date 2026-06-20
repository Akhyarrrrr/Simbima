@section('eyebrow', 'DETAIL BIMBINGAN')
@section('title', $bimbingan->mahasiswa->user->name)

<x-app-layout>
    @php
        $user = auth()->user();
        $dosen = $user->role === 'dosen' ? $user->dosen : null;
        $isDospem1 = $dosen && $bimbingan->dospem1_id === $dosen->id;
    @endphp

    <div class="max-w-5xl space-y-6">
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
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Ringkasan</p>
                <h3 class="mt-1 font-display text-lg font-semibold text-navy">Data Bimbingan</h3>
            </div>

            <dl class="grid gap-4 md:grid-cols-3">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Mahasiswa</dt>
                    <dd class="mt-1 text-sm font-medium text-navy">{{ $bimbingan->mahasiswa->user->name }}</dd>
                    <dd class="mt-1 font-mono text-xs text-slate">{{ $bimbingan->mahasiswa->nim }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Dospem 1</dt>
                    <dd class="mt-1 text-sm font-medium text-navy">{{ $bimbingan->dospem1->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Dospem 2</dt>
                    <dd class="mt-1 text-sm font-medium text-navy">{{ $bimbingan->dospem2?->user?->name ?? 'Belum ditentukan' }}</dd>
                </div>
                <div class="md:col-span-3">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Judul TA</dt>
                    <dd class="mt-1 font-display text-lg font-semibold text-navy">{{ $bimbingan->judul_ta ?: 'Belum ditentukan' }}</dd>
                </div>
            </dl>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Status</p>
                <h3 class="mt-1 font-display text-lg font-semibold text-navy">Kesiapan Tahapan</h3>
            </div>

            @include('partials.readiness-badges', ['bimbingan' => $bimbingan])

            @if ($isDospem1)
                <form method="POST" action="{{ route('dosen.bimbingan.status.update', $bimbingan) }}" class="mt-5 rounded-lg border border-slate-200 bg-paper/50 p-4">
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="boleh_sempro" value="0">
                    <input type="hidden" name="boleh_semhas" value="0">
                    <input type="hidden" name="boleh_sidang" value="0">

                    <div class="grid gap-3 sm:grid-cols-3">
                        <label class="flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-navy">
                            <input type="checkbox" name="boleh_sempro" value="1" @checked($bimbingan->boleh_sempro) class="rounded border-slate-300 text-forest focus:ring-forest">
                            Boleh Sempro
                        </label>
                        <label class="flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-navy">
                            <input type="checkbox" name="boleh_semhas" value="1" @checked($bimbingan->boleh_semhas) class="rounded border-slate-300 text-forest focus:ring-forest">
                            Boleh Semhas
                        </label>
                        <label class="flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-navy">
                            <input type="checkbox" name="boleh_sidang" value="1" @checked($bimbingan->boleh_sidang) class="rounded border-slate-300 text-forest focus:ring-forest">
                            Boleh Sidang
                        </label>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="inline-flex h-10 items-center rounded-md bg-navy px-4 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                            Simpan Status
                        </button>
                    </div>
                </form>
            @endif
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Log</p>
                <h3 class="mt-1 font-display text-lg font-semibold text-navy">Catatan Bimbingan</h3>
            </div>

            @if ($user->role === 'admin')
                <div class="space-y-3">
                    @forelse ($bimbingan->catatans as $catatan)
                        <article class="rounded-lg border border-slate-200 bg-white px-4 py-3 shadow-sm">
                            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-sm font-semibold text-navy">{{ $catatan->user->name }}</p>
                                <p class="text-xs text-slate">{{ $catatan->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate">{{ $catatan->isi }}</p>
                        </article>
                    @empty
                        <p class="rounded-lg border border-dashed border-slate-300 px-4 py-5 text-center text-sm italic text-slate">Belum ada catatan bimbingan.</p>
                    @endforelse
                </div>
            @else
                @include('partials.catatan-bimbingan', ['bimbingan' => $bimbingan])
            @endif
        </section>
    </div>
</x-app-layout>
