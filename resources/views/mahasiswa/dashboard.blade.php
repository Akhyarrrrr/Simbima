@section('eyebrow', 'DASHBOARD MAHASISWA')
@section('title', 'Halo, '.$mahasiswa->user->name)

<x-app-layout>
    @php
        $hasBidangMinat = (bool) $mahasiswa->bidang_minat_id;
        $currentStage = 0;

        if ($hasBidangMinat) {
            $currentStage = 1;
        }

        if ($pengajuanAktif) {
            $currentStage = 2;
        }

        if ($bimbinganProgres && $bimbinganProgres->status === 'aktif') {
            $currentStage = 4;
        }

        if ($bimbinganProgres && $bimbinganProgres->status === 'selesai') {
            $currentStage = 5;
        }

        $stages = [
            [
                'label' => 'Pilih Minat',
                'detail' => $hasBidangMinat ? $mahasiswa->bidangMinat->nama : 'Tentukan bidang minat terlebih dahulu',
            ],
            [
                'label' => 'Pengajuan',
                'detail' => $pengajuanAktif
                    ? 'Menunggu persetujuan '.$pengajuanAktif->dosen->user->name
                    : ($currentStage > 2 ? 'Pengajuan telah diproses' : 'Pilih dosen pembimbing sesuai minat'),
            ],
            [
                'label' => 'Diterima',
                'detail' => $currentStage >= 3 ? 'Dosen pembimbing utama telah ditetapkan' : 'Menunggu keputusan dosen',
            ],
            [
                'label' => 'Bimbingan Aktif',
                'detail' => $bimbinganProgres
                    ? 'Pembimbing 1: '.$bimbinganProgres->dospem1->user->name
                    : 'Belum memasuki proses bimbingan',
            ],
            [
                'label' => 'Selesai',
                'detail' => $currentStage === 5 ? 'Bimbingan tugas akhir selesai' : 'Tahap akhir belum tercapai',
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

        <section class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-4 border-b border-gold/30 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate">Profil Akademik</p>
                        <h3 class="mt-1 font-display text-xl font-semibold text-navy">Informasi Mahasiswa</h3>
                    </div>
                    <span class="inline-flex w-fit rounded-full border {{ $hasBidangMinat ? 'border-forest/30 bg-forest/10 text-forest' : 'border-gold/50 bg-gold/10 text-gold' }} px-3 py-1 text-xs font-semibold uppercase tracking-wide">
                        {{ $hasBidangMinat ? 'Minat sudah dipilih' : 'Perlu pilih minat' }}
                    </span>
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
                        <dd class="mt-1 text-sm font-medium text-navy">{{ $mahasiswa->bidangMinat?->nama ?? 'Belum dipilih' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-xl border border-navy/10 bg-navy p-6 text-white shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gold">Langkah Berikutnya</p>
                <h3 class="mt-2 font-display text-xl font-semibold">
                    @if (! $hasBidangMinat)
                        Pilih bidang minat untuk membuka daftar dosen.
                    @elseif ($bimbingan)
                        Lengkapi detail bimbingan tugas akhir.
                    @elseif ($pengajuanAktif)
                        Tunggu keputusan dosen pembimbing.
                    @else
                        Ajukan calon dosen pembimbing.
                    @endif
                </h3>
                <p class="mt-3 text-sm leading-6 text-slate-200">
                    SIMBIMA menampilkan dosen berdasarkan bidang minat yang kamu pilih, sehingga pengajuan lebih terarah dan slot pembimbing lebih mudah dipantau.
                </p>
            </div>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">
            <div class="mb-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Progres Bimbingan</p>
                <h3 class="mt-1 font-display text-lg font-semibold text-navy">Alur Tugas Akhir</h3>
            </div>

            <ol class="grid gap-5 lg:grid-cols-5">
                @foreach ($stages as $index => $stage)
                    @php
                        $stageNumber = $index + 1;
                        $isReached = $currentStage >= $stageNumber;
                    @endphp

                    <li class="relative rounded-lg border {{ $isReached ? 'border-forest/30 bg-forest/5' : 'border-slate-200 bg-white' }} p-4">
                        <div class="mb-3 flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full {{ $isReached ? 'bg-forest text-white' : 'border border-slate-300 text-slate' }} font-mono text-xs font-semibold">
                                {{ $stageNumber }}
                            </span>
                            <p class="text-sm font-semibold {{ $isReached ? 'text-navy' : 'text-slate' }}">{{ $stage['label'] }}</p>
                        </div>
                        <p class="text-xs leading-5 text-slate">{{ $stage['detail'] }}</p>
                    </li>
                @endforeach
            </ol>
        </section>

        @if (! $hasBidangMinat)
            <section class="rounded-xl border border-gold/40 bg-white shadow-sm">
                <div class="grid gap-0 lg:grid-cols-[0.85fr_1.15fr]">
                    <div class="border-b border-gold/30 bg-paper/70 px-6 py-6 lg:border-b-0 lg:border-r">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate">Mulai Dari Sini</p>
                        <h3 class="mt-2 font-display text-2xl font-semibold text-navy">Pilih bidang minat</h3>
                        <p class="mt-3 text-sm leading-6 text-slate">
                            Pilihan ini menentukan daftar dosen yang bisa kamu ajukan sebagai pembimbing utama. Kamu masih bisa meminta admin membantu jika salah memilih sebelum ada pengajuan.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('mahasiswa.bidang-minat.update') }}" class="space-y-5 px-6 py-6">
                        @csrf
                        @method('PATCH')

                        <div class="grid gap-3 sm:grid-cols-2">
                            @foreach ($bidangMinats as $bidangMinat)
                                <label class="group relative flex cursor-pointer rounded-lg border border-slate-200 bg-white p-4 transition hover:border-gold hover:bg-gold/5 has-[:checked]:border-navy has-[:checked]:bg-navy/5">
                                    <input type="radio" name="bidang_minat_id" value="{{ $bidangMinat->id }}" class="peer sr-only" required>
                                    <span class="flex-1">
                                        <span class="block font-display text-base font-semibold text-navy">{{ $bidangMinat->nama }}</span>
                                        <span class="mt-1 block text-xs text-slate">{{ $bidangMinat->dosens_count }} dosen tersedia</span>
                                    </span>
                                    <span class="ml-3 mt-1 h-4 w-4 rounded-full border border-slate-300 peer-checked:border-navy peer-checked:bg-navy"></span>
                                </label>
                            @endforeach
                        </div>

                        <div class="flex justify-end border-t border-slate-100 pt-5">
                            <button type="submit" class="inline-flex h-10 items-center rounded-md bg-navy px-5 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                                Simpan Bidang Minat
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        @elseif ($bimbingan)
            <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-gold/30 px-6 py-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate">Bimbingan</p>
                    <h3 class="mt-1 font-display text-lg font-semibold text-navy">Bimbingan Aktif</h3>
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

                        <div class="rounded-md border border-slate-200 bg-paper/70 px-4 py-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate">Dospem 2</p>
                            <p class="mt-1 text-sm font-medium text-navy">{{ $bimbingan->dospem2?->user?->name ?? 'Belum ditentukan oleh pembimbing' }}</p>
                            <p class="mt-1 text-xs text-slate">Dospem 2 ditetapkan oleh dospem 1 atau admin.</p>
                        </div>
                    </div>

                    <div class="flex justify-end border-t border-slate-100 pt-5">
                        <a href="{{ route('bimbingan.show', $bimbingan) }}" class="mr-3 inline-flex h-10 items-center rounded-md border border-navy px-4 text-sm font-semibold text-navy transition-colors hover:bg-navy hover:text-white focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                            Detail Bimbingan
                        </a>
                        <button type="submit" class="inline-flex h-10 items-center rounded-md bg-navy px-4 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

                <div class="space-y-6 border-t border-slate-100 px-6 py-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate">Status Kesiapan</p>
                        <h4 class="mt-1 font-display text-lg font-semibold text-navy">Izin Tahapan Akademik</h4>
                        <div class="mt-4">
                            @include('partials.readiness-badges', ['bimbingan' => $bimbingan])
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate">Log Bimbingan</p>
                        <h4 class="mt-1 font-display text-lg font-semibold text-navy">Catatan Bimbingan</h4>
                        <div class="mt-4">
                            @include('partials.catatan-bimbingan', ['bimbingan' => $bimbingan])
                        </div>
                    </div>
                </div>
            </section>
        @elseif ($pengajuanAktif)
            <section class="rounded-xl border border-gold/40 bg-white shadow-sm">
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
            <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-1 border-b border-gold/30 px-6 py-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate">{{ $mahasiswa->bidangMinat->nama }}</p>
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
                                    <td class="px-6 py-8 text-center text-slate" colspan="4">Belum ada dosen untuk bidang minat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        @endif

        @if ($riwayatDitolak->isNotEmpty())
            <section x-data="{ open: false }" class="rounded-xl border border-slate-200 bg-white shadow-sm">
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
