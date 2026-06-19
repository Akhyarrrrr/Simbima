@section('eyebrow', 'DASHBOARD DOSEN')
@section('title', 'Selamat datang, '.auth()->user()->name)

<x-app-layout>
    <div class="space-y-6">
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
            <div class="mb-5">
                <h3 class="font-display text-lg font-semibold text-navy">Pengajuan Masuk</h3>
                <div class="mt-2 flex items-center gap-2">
                    <p class="font-sans text-xs font-semibold uppercase tracking-wide text-slate">Pengajuan Masuk</p>
                    <span class="rounded-full bg-gold/10 px-2 py-0.5 text-xs font-semibold text-gold">
                        {{ $pendingPengajuans->count() }}
                    </span>
                </div>
            </div>

            @if ($pendingPengajuans->isEmpty())
                <p class="font-sans text-sm italic text-slate">Belum ada pengajuan masuk.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-left text-sm">
                        <thead class="border-b border-slate-200 bg-navy/5 text-xs font-semibold uppercase tracking-wide text-navy">
                            <tr>
                                <th scope="col" class="px-4 py-3">Nama</th>
                                <th scope="col" class="px-4 py-3">NIM</th>
                                <th scope="col" class="px-4 py-3">Angkatan</th>
                                <th scope="col" class="px-4 py-3">Bidang Minat</th>
                                <th scope="col" class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($pendingPengajuans as $pengajuan)
                                <tr class="border-b border-slate-100 last:border-b-0 hover:bg-paper/60" x-data="{ rejectOpen: false }">
                                    <td class="whitespace-nowrap px-4 py-4 font-medium text-navy">{{ $pengajuan->mahasiswa->user->name }}</td>
                                    <td class="whitespace-nowrap px-4 py-4 font-mono text-sm text-slate">{{ $pengajuan->mahasiswa->nim }}</td>
                                    <td class="whitespace-nowrap px-4 py-4 text-slate">{{ $pengajuan->mahasiswa->angkatan }}</td>
                                    <td class="whitespace-nowrap px-4 py-4 text-slate">{{ $pengajuan->mahasiswa->bidangMinat->nama }}</td>
                                    <td class="whitespace-nowrap px-4 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <form method="POST" action="{{ route('dosen.pengajuan.approve', $pengajuan) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center rounded-md bg-forest px-3 py-1.5 text-sm font-semibold text-white transition-colors hover:bg-forest/90 focus:outline-none focus:ring-2 focus:ring-forest focus:ring-offset-2">
                                                    ACC
                                                </button>
                                            </form>
                                            <button type="button" x-on:click="rejectOpen = true" class="inline-flex items-center rounded-md border border-rust px-3 py-1.5 text-sm font-semibold text-rust transition-colors hover:bg-rust hover:text-white focus:outline-none focus:ring-2 focus:ring-rust focus:ring-offset-2">
                                                Tolak
                                            </button>
                                        </div>

                                        <div class="fixed inset-0 z-50 hidden items-center justify-center bg-navy/40 px-4" x-bind:class="{ 'hidden': !rejectOpen, 'flex': rejectOpen }" role="dialog" aria-modal="true" aria-labelledby="reject-title-{{ $pengajuan->id }}" x-on:keydown.escape.window="rejectOpen = false">
                                            <div x-on:click="rejectOpen = false" class="absolute inset-0"></div>
                                            <form method="POST" action="{{ route('dosen.pengajuan.reject', $pengajuan) }}" class="relative w-full max-w-lg rounded-lg bg-white p-6 text-left shadow-lg">
                                                @csrf
                                                @method('PATCH')
                                                <h4 id="reject-title-{{ $pengajuan->id }}" class="font-display text-lg font-semibold text-navy">Tolak Pengajuan</h4>
                                                <p class="mt-1 text-sm text-slate">Berikan catatan agar mahasiswa memahami alasan penolakan.</p>
                                                <div class="mt-5">
                                                    <x-input-label for="catatan_penolakan_{{ $pengajuan->id }}" value="Catatan Penolakan" class="text-slate" />
                                                    <textarea id="catatan_penolakan_{{ $pengajuan->id }}" name="catatan_penolakan" rows="4" required class="mt-1 block w-full rounded-md border-slate-300 text-sm text-navy shadow-sm focus:border-rust focus:ring-rust"></textarea>
                                                </div>
                                                <div class="mt-6 flex justify-end gap-3">
                                                    <button type="button" x-on:click="rejectOpen = false" class="inline-flex h-10 items-center rounded-md border border-slate-300 bg-white px-4 text-sm font-semibold text-slate transition-colors hover:bg-paper focus:outline-none focus:ring-2 focus:ring-slate focus:ring-offset-2">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="inline-flex h-10 items-center rounded-md bg-rust px-4 text-sm font-semibold text-white transition-colors hover:bg-rust/90 focus:outline-none focus:ring-2 focus:ring-rust focus:ring-offset-2">
                                                        Tolak Pengajuan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5">
                <h3 class="font-display text-lg font-semibold text-navy">Mahasiswa Bimbingan Aktif</h3>
                <div class="mt-2 flex items-center gap-2">
                    <p class="font-sans text-xs font-semibold uppercase tracking-wide text-slate">Bimbingan Aktif</p>
                    <span class="rounded-full bg-gold/10 px-2 py-0.5 text-xs font-semibold text-gold">
                        {{ $activeBimbingans->count() }}
                    </span>
                </div>
            </div>

            @if ($activeBimbingans->isEmpty())
                <p class="font-sans text-sm italic text-slate">Belum ada mahasiswa bimbingan aktif.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-left text-sm">
                        <thead class="border-b border-slate-200 bg-navy/5 text-xs font-semibold uppercase tracking-wide text-navy">
                            <tr>
                                <th scope="col" class="px-4 py-3">Nama</th>
                                <th scope="col" class="px-4 py-3">NIM</th>
                                <th scope="col" class="px-4 py-3">Judul TA</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($activeBimbingans as $bimbingan)
                                <tr class="border-b border-slate-100 last:border-b-0 hover:bg-paper/60">
                                    <td class="whitespace-nowrap px-4 py-4 font-medium text-navy">{{ $bimbingan->mahasiswa->user->name }}</td>
                                    <td class="whitespace-nowrap px-4 py-4 font-mono text-sm text-slate">{{ $bimbingan->mahasiswa->nim }}</td>
                                    <td class="px-4 py-4">
                                        @if ($bimbingan->judul_ta)
                                            <span class="font-display text-sm font-semibold text-navy">{{ $bimbingan->judul_ta }}</span>
                                        @else
                                            <span class="text-sm italic text-slate">Belum ditentukan</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
