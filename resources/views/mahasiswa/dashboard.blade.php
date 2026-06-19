@section('eyebrow', 'DASHBOARD MAHASISWA')
@section('title', 'Halo, '.$mahasiswa->user->name)

<x-app-layout>
    @php
        $currentStage = 0;

        if ($pengajuanAktif) {
            $currentStage = 1;
        }

        if ($bimbinganProgres && $bimbinganProgres->status === 'aktif') {
            $currentStage = 3;
        }

        if ($bimbinganProgres && $bimbinganProgres->status === 'selesai') {
            $currentStage = 4;
        }

        $stages = [
            [
                'label' => 'Pengajuan',
                'detail' => $pengajuanAktif
                    ? 'Menunggu persetujuan '.$pengajuanAktif->dosen->user->name
                    : ($currentStage > 1 ? 'Pengajuan telah diterima' : 'Belum ada pengajuan aktif'),
            ],
            [
                'label' => 'Diterima',
                'detail' => $currentStage >= 2 ? 'Dosen pembimbing utama telah ditetapkan' : 'Menunggu keputusan dosen',
            ],
            [
                'label' => 'Bimbingan Aktif',
                'detail' => $bimbinganProgres
                    ? 'Pembimbing 1: '.$bimbinganProgres->dospem1->user->name
                    : 'Belum memasuki proses bimbingan',
            ],
            [
                'label' => 'Selesai',
                'detail' => $currentStage === 4 ? 'Bimbingan tugas akhir selesai' : 'Tahap akhir belum tercapai',
            ],
        ];
    @endphp

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

        <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-gold/30 px-6 py-4">
                <h3 class="font-display text-lg font-semibold text-navy">Informasi Mahasiswa</h3>
            </div>
            <dl class="grid divide-y divide-slate-100 sm:grid-cols-2 sm:divide-x sm:divide-y-0 lg:grid-cols-4">
                <div class="px-6 py-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Nama</dt>
                    <dd class="mt-1 text-sm font-medium text-navy">{{ $mahasiswa->user->name }}</dd>
                </div>
                <div class="px-6 py-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">NIM</dt>
                    <dd class="mt-1 font-mono text-sm font-medium text-navy">{{ $mahasiswa->nim }}</dd>
                </div>
                <div class="px-6 py-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Angkatan</dt>
                    <dd class="mt-1 text-sm font-medium text-navy">{{ $mahasiswa->angkatan }}</dd>
                </div>
                <div class="px-6 py-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate">Bidang Minat</dt>
                    <dd class="mt-1 text-sm font-medium text-navy">{{ $mahasiswa->bidangMinat->nama }}</dd>
                </div>
            </dl>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white px-6 py-5 shadow-sm">
            <div class="mb-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Progres Bimbingan</p>
                <h3 class="mt-1 font-display text-lg font-semibold text-navy">Alur Tugas Akhir</h3>
            </div>

            <ol class="space-y-0">
                @foreach ($stages as $index => $stage)
                    @php
                        $stageNumber = $index + 1;
                        $isReached = $currentStage >= $stageNumber;
                        $isPassed = $currentStage > $stageNumber;
                    @endphp

                    <li class="relative flex gap-4 pb-7 last:pb-0">
                        @if (! $loop->last)
                            <div class="absolute left-[9px] top-5 h-full w-px {{ $isPassed ? 'bg-forest' : 'bg-slate-200' }}" aria-hidden="true"></div>
                        @endif

                        <div class="relative z-10 mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full {{ $isReached ? 'bg-forest ring-4 ring-forest/10' : 'border border-slate-300 bg-white' }}" aria-hidden="true">
                            @if ($isReached)
                                <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                            @endif
                        </div>

                        <div class="-mt-0.5">
                            <p class="text-sm font-semibold {{ $isReached ? 'text-navy' : 'text-slate' }}">{{ $stage['label'] }}</p>
                            <p class="mt-0.5 text-xs text-slate">{{ $stage['detail'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </section>

        @if ($bimbingan)
            <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-gold/30 px-6 py-4">
                    <h3 class="font-display text-lg font-semibold text-navy">Bimbingan Aktif</h3>
                </div>
                <form method="POST" action="{{ route('mahasiswa.bimbingan.update', $bimbingan) }}" class="space-y-6 px-6 py-5">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="judul_ta" value="Judul TA" class="text-slate" />
                        <input id="judul_ta" name="judul_ta" class="mt-2 block w-full border-0 border-b border-gold bg-transparent px-0 py-2 font-display text-xl font-semibold text-navy placeholder:text-slate/60 focus:border-gold focus:outline-none focus:ring-0" value="{{ old('judul_ta', $bimbingan->judul_ta) }}" placeholder="Masukkan judul tugas akhir">
                    </div>

                    <div class="grid gap-5 lg:grid-cols-2">
                        <div class="rounded-md border border-slate-200 bg-paper/70 px-4 py-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate">Dospem 1</p>
                            <p class="mt-1 text-sm font-medium text-navy">{{ $bimbingan->dospem1->user->name }}</p>
                        </div>

                        <div>
                            <x-input-label for="dospem2_id" value="Dospem 2" class="text-slate" />
                            <select id="dospem2_id" name="dospem2_id" class="mt-1 block h-10 w-full rounded-md border-slate-300 text-sm text-navy shadow-sm focus:border-navy focus:ring-navy">
                                <option value="">Belum ditentukan</option>
                                @foreach ($allDosens as $dosen)
                                    <option value="{{ $dosen->id }}" @selected(old('dospem2_id', $bimbingan->dospem2_id) == $dosen->id)>
                                        {{ $dosen->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end border-t border-slate-100 pt-5">
                        <button type="submit" class="inline-flex h-10 items-center rounded-md bg-navy px-4 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </section>
        @elseif ($pengajuanAktif)
            <section class="rounded-lg border border-gold/40 bg-white shadow-sm">
                <div class="flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="flex flex-wrap items-center gap-3">
                            <h3 class="font-display text-lg font-semibold text-navy">Pengajuan Aktif</h3>
                            <span class="rounded-full border border-gold bg-gold/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-gold">
                                Menunggu
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-slate">
                            Dosen tujuan: <span class="font-medium text-navy">{{ $pengajuanAktif->dosen->user->name }}</span>
                        </p>
                    </div>
                    <form method="POST" action="{{ route('mahasiswa.pengajuan.destroy', $pengajuanAktif) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex h-10 items-center rounded-md border border-rust px-4 text-sm font-semibold text-rust transition-colors hover:bg-rust hover:text-white focus:outline-none focus:ring-2 focus:ring-rust focus:ring-offset-2">
                            Batalkan Pengajuan
                        </button>
                    </form>
                </div>
            </section>
        @else
            <section class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-1 border-b border-gold/30 px-6 py-4">
                    <h3 class="font-display text-lg font-semibold text-navy">Daftar Dosen Sesuai Bidang Minat</h3>
                    <p class="text-sm text-slate">Ajukan dosen pembimbing berdasarkan ketersediaan slot angkatan {{ $mahasiswa->angkatan }}.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-left text-sm">
                        <thead class="bg-navy/5 text-xs font-semibold uppercase tracking-wide text-navy">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">NIP</th>
                                <th scope="col" class="px-6 py-3">Sisa Slot</th>
                                <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse ($dosens as $dosen)
                                @php
                                    $maxSlot = $dosen->dosenSlots->firstWhere('angkatan', $mahasiswa->angkatan)?->max_slot ?? 10;
                                @endphp

                                <tr class="border-b border-slate-100 last:border-b-0 hover:bg-paper/60">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium text-navy">{{ $dosen->user->name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 font-mono text-sm text-slate">{{ $dosen->nip }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="font-mono text-sm font-semibold {{ $dosen->sisa_slot > 0 ? 'text-forest' : 'text-rust' }}">
                                            {{ $dosen->sisa_slot }}/{{ $maxSlot }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <form method="POST" action="{{ route('mahasiswa.pengajuan.store') }}">
                                            @csrf
                                            <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">
                                            <button type="submit" @disabled($dosen->sisa_slot <= 0) class="inline-flex items-center rounded-md bg-navy px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2 disabled:cursor-not-allowed disabled:bg-slate-200 disabled:text-slate-400">
                                                {{ $dosen->sisa_slot > 0 ? 'Ajukan' : 'Slot Penuh' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-6 text-center text-slate" colspan="4">Belum ada dosen untuk bidang minat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        @endif

        @if ($riwayatDitolak->isNotEmpty())
            <section x-data="{ open: false }" class="rounded-lg border border-slate-200 bg-white shadow-sm">
                <button type="button" x-on:click="open = !open" class="flex w-full items-center justify-between gap-4 px-6 py-4 text-left focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                    <span class="flex items-center gap-3">
                        <span class="text-sm font-medium text-navy">Riwayat Pengajuan Ditolak</span>
                        <span class="rounded-full bg-rust/10 px-2 py-0.5 text-xs font-semibold text-rust">
                            {{ $riwayatDitolak->count() }}
                        </span>
                    </span>

                    <svg class="h-4 w-4 text-slate transition-transform" x-bind:class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="open" x-cloak class="space-y-3 border-t border-slate-100 px-6 py-4">
                    @foreach ($riwayatDitolak as $pengajuanDitolak)
                        <article class="rounded-md border border-rust/20 bg-rust/5 px-4 py-3">
                            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-sm font-medium text-navy">{{ $pengajuanDitolak->dosen->user->name }}</p>
                                <p class="text-xs text-slate">{{ $pengajuanDitolak->created_at->format('d M Y') }}</p>
                            </div>
                            <p class="mt-2 text-sm italic text-slate">
                                {{ $pengajuanDitolak->catatan_penolakan ?: 'Tidak ada catatan penolakan.' }}
                            </p>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-app-layout>
