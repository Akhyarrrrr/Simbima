@section('eyebrow', 'DASHBOARD ADMIN')
@section('title', 'Ringkasan Sistem')

<x-app-layout>
    <div class="space-y-6">
        <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div class="rounded-lg border border-slate-200 border-t-gold border-t-2 bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Total Mahasiswa</p>
                <p class="mt-3 font-display text-3xl font-semibold text-navy">{{ $stats['total_mahasiswa'] }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 border-t-gold border-t-2 bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Total Dosen</p>
                <p class="mt-3 font-display text-3xl font-semibold text-navy">{{ $stats['total_dosen'] }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 border-t-gold border-t-2 bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Bimbingan Aktif</p>
                <p class="mt-3 font-display text-3xl font-semibold text-navy">{{ $stats['bimbingan_aktif'] }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 border-t-gold border-t-2 bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Pengajuan Pending</p>
                <p class="mt-3 font-display text-3xl font-semibold text-navy">{{ $stats['pending_pengajuan'] }}</p>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2">
            <a href="/admin/dosen" class="group rounded-lg bg-navy p-6 text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="font-display text-lg font-semibold">Kelola Dosen</h3>
                        <p class="mt-1 text-sm text-slate-200">Atur data dosen dan slot pembimbing.</p>
                    </div>
                    <svg class="h-5 w-5 shrink-0 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
                    </svg>
                </div>
            </a>

            <a href="/admin/mahasiswa" class="group rounded-lg bg-navy p-6 text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="font-display text-lg font-semibold">Kelola Mahasiswa</h3>
                        <p class="mt-1 text-sm text-slate-200">Atur data mahasiswa dan bidang minat.</p>
                    </div>
                    <svg class="h-5 w-5 shrink-0 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
                    </svg>
                </div>
            </a>
        </section>
    </div>
</x-app-layout>
