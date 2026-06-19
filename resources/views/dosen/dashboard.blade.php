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
                <div class="space-y-4">
                    @foreach ($activeBimbingans as $bimbingan)
                        @php
                            $isDospem1 = $bimbingan->dospem1_id === $dosen->id;
                        @endphp

                        <article x-data="{ open: false }" class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                            <div class="grid gap-4 bg-paper/60 px-4 py-4 lg:grid-cols-[1fr_auto] lg:items-center">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h4 class="font-display text-base font-semibold text-navy">{{ $bimbingan->mahasiswa->user->name }}</h4>
                                        <span class="rounded-full border {{ $isDospem1 ? 'border-forest/30 bg-forest/10 text-forest' : 'border-gold/40 bg-gold/10 text-gold' }} px-2 py-0.5 text-xs font-semibold uppercase tracking-wide">
                                            {{ $isDospem1 ? 'Dospem 1' : 'Dospem 2' }}
                                        </span>
                                    </div>
                                    <p class="mt-1 font-mono text-xs text-slate">{{ $bimbingan->mahasiswa->nim }}</p>
                                    <p class="mt-2 text-sm text-slate">
                                        @if ($bimbingan->judul_ta)
                                            <span class="font-display font-semibold text-navy">{{ $bimbingan->judul_ta }}</span>
                                        @else
                                            <span class="italic">Judul TA belum ditentukan</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="flex flex-wrap items-center gap-2 lg:justify-end">
                                    <button type="button" x-on:click="open = !open" class="inline-flex items-center rounded-md border border-navy px-3 py-1.5 text-sm font-semibold text-navy transition-colors hover:bg-navy hover:text-white focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                                        <span x-text="open ? 'Tutup Detail' : 'Buka Detail'"></span>
                                    </button>

                                    @if ($isDospem1)
                                        <form method="POST" action="{{ route('dosen.bimbingan.selesai', $bimbingan) }}" onsubmit="return confirm('Tandai bimbingan ini sebagai selesai?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center rounded-md border border-forest px-3 py-1.5 text-sm font-semibold text-forest transition-colors hover:bg-forest hover:text-white focus:outline-none focus:ring-2 focus:ring-forest focus:ring-offset-2">
                                                Tandai Selesai
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div x-show="open" x-cloak class="space-y-6 border-t border-slate-200 px-4 py-5">
                                <div>
                                    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-slate">Status Kesiapan</p>
                                            <h5 class="mt-1 font-display text-lg font-semibold text-navy">Sempro, Semhas, Sidang</h5>
                                        </div>
                                        @if (! $isDospem1)
                                            <p class="text-xs italic text-slate">Hanya pembimbing 1 yang dapat mengubah status ini.</p>
                                        @endif
                                    </div>

                                    <div class="mt-4">
                                        @include('partials.readiness-badges', ['bimbingan' => $bimbingan])
                                    </div>

                                    @if ($isDospem1)
                                        <form method="POST" action="{{ route('dosen.bimbingan.status.update', $bimbingan) }}" class="mt-4 rounded-lg border border-slate-200 bg-paper/50 p-4">
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
                                </div>

                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate">Log Bimbingan</p>
                                    <h5 class="mt-1 font-display text-lg font-semibold text-navy">Catatan Bimbingan</h5>
                                    <div class="mt-4">
                                        @include('partials.catatan-bimbingan', ['bimbingan' => $bimbingan])
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
