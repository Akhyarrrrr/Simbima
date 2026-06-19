@section('eyebrow', 'DETAIL MAHASISWA')
@section('title', $mahasiswa->user->name)

<x-app-layout>
    <div class="max-w-3xl space-y-6">
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

        <div>
            <a class="inline-flex items-center rounded-md border border-navy px-4 py-2 text-sm font-semibold text-navy transition-colors hover:bg-navy hover:text-white focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2" href="{{ route('admin.mahasiswa.index') }}">
                Kembali
            </a>
        </div>
    </div>
</x-app-layout>
