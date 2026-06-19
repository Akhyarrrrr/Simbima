@php
    $kategoriStyles = [
        'revisi' => 'border-rust bg-rust/5 text-rust',
        'saran' => 'border-gold bg-gold/5 text-gold',
        'progress' => 'border-forest bg-forest/5 text-forest',
    ];
@endphp

<div class="space-y-5">
    <form method="POST" action="{{ route('bimbingan.catatan.store', $bimbingan) }}" class="rounded-lg border border-slate-200 bg-paper/50 p-4">
        @csrf

        <div class="grid gap-4 lg:grid-cols-[180px_1fr]">
            <div>
                <x-input-label for="kategori_{{ $bimbingan->id }}" value="Kategori" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
                <select id="kategori_{{ $bimbingan->id }}" name="kategori" required class="block w-full rounded-md border-slate-300 text-sm text-navy shadow-sm focus:border-navy focus:ring-navy">
                    <option value="progress">Progress</option>
                    <option value="saran">Saran</option>
                    <option value="revisi">Revisi</option>
                </select>
            </div>
            <div>
                <x-input-label for="isi_catatan_{{ $bimbingan->id }}" value="Catatan" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
                <textarea id="isi_catatan_{{ $bimbingan->id }}" name="isi" rows="3" required maxlength="2000" placeholder="Tulis progress, saran, atau revisi bimbingan..." class="block w-full rounded-md border-slate-300 text-sm text-navy shadow-sm focus:border-navy focus:ring-navy"></textarea>
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <button type="submit" class="inline-flex h-10 items-center rounded-md bg-navy px-4 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                Tambah Catatan
            </button>
        </div>
    </form>

    <div class="space-y-3">
        @forelse ($bimbingan->catatans as $catatan)
            @php
                $style = $kategoriStyles[$catatan->kategori] ?? $kategoriStyles['progress'];
                $roleLabel = match ($catatan->user->role) {
                    'dosen' => 'Dosen',
                    'mahasiswa' => 'Mahasiswa',
                    'admin' => 'Admin',
                    default => 'Pengguna',
                };
            @endphp

            <article class="rounded-lg border-l-4 border-y border-r border-slate-200 bg-white px-4 py-3 shadow-sm {{ str($style)->before(' ') }}">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-full border px-2 py-0.5 text-xs font-semibold uppercase tracking-wide {{ $style }}">
                            {{ $catatan->kategori }}
                        </span>
                        <p class="text-sm font-semibold text-navy">{{ $catatan->user->name }}</p>
                        <span class="text-xs text-slate">({{ $roleLabel }})</span>
                    </div>
                    <p class="text-xs text-slate">{{ $catatan->created_at->diffForHumans() }}</p>
                </div>
                <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate">{{ $catatan->isi }}</p>
            </article>
        @empty
            <p class="rounded-lg border border-dashed border-slate-300 px-4 py-5 text-center text-sm italic text-slate">
                Belum ada catatan bimbingan.
            </p>
        @endforelse
    </div>
</div>
