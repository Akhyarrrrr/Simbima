<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-semibold leading-tight text-gray-900">Dashboard Mahasiswa</h2>
            <p class="text-sm text-gray-500">Pantau pengajuan pembimbing dan data bimbingan tugas akhir.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                    {{ $errors->first() }}
                </div>
            @endif

            <section class="rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h3 class="text-base font-semibold text-gray-900">Informasi Mahasiswa</h3>
                </div>
                <dl class="grid gap-0 divide-y divide-gray-200 sm:grid-cols-2 sm:divide-x sm:divide-y-0 lg:grid-cols-4">
                    <div class="px-6 py-4">
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Nama</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $mahasiswa->user->name }}</dd>
                    </div>
                    <div class="px-6 py-4">
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">NIM</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $mahasiswa->nim }}</dd>
                    </div>
                    <div class="px-6 py-4">
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Angkatan</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $mahasiswa->angkatan }}</dd>
                    </div>
                    <div class="px-6 py-4">
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Bidang Minat</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $mahasiswa->bidangMinat->nama }}</dd>
                    </div>
                </dl>
            </section>

            @if ($bimbingan)
                <section class="rounded-lg border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-base font-semibold text-gray-900">Bimbingan Aktif</h3>
                    </div>
                    <form method="POST" action="{{ route('mahasiswa.bimbingan.update', $bimbingan) }}" class="space-y-5 px-6 py-5">
                        @csrf
                        @method('PATCH')

                        <div class="grid gap-5 lg:grid-cols-2">
                            <div>
                                <x-input-label for="judul_ta" value="Judul TA" />
                                <x-text-input id="judul_ta" name="judul_ta" class="mt-1 block h-10 w-full" value="{{ old('judul_ta', $bimbingan->judul_ta) }}" placeholder="Masukkan judul tugas akhir" />
                            </div>
                            <div>
                                <x-input-label for="dospem2_id" value="Dospem 2" />
                                <select id="dospem2_id" name="dospem2_id" class="mt-1 block h-10 w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Belum ditentukan</option>
                                    @foreach ($allDosens as $dosen)
                                        <option value="{{ $dosen->id }}" @selected(old('dospem2_id', $bimbingan->dospem2_id) == $dosen->id)>
                                            {{ $dosen->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid gap-5 border-t border-gray-200 pt-5 sm:grid-cols-2">
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Dospem 1</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">{{ $bimbingan->dospem1->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Dospem 2 Saat Ini</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">{{ $bimbingan->dospem2?->user?->name ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>Simpan Perubahan</x-primary-button>
                        </div>
                    </form>
                </section>
            @elseif ($pengajuanAktif)
                <section class="rounded-lg border border-amber-200 bg-amber-50 shadow-sm">
                    <div class="flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-amber-950">Pengajuan Menunggu Persetujuan</h3>
                            <p class="mt-1 text-sm text-amber-800">
                                Dosen tujuan: <span class="font-semibold">{{ $pengajuanAktif->dosen->user->name }}</span>
                            </p>
                        </div>
                        <form method="POST" action="{{ route('mahasiswa.pengajuan.destroy', $pengajuanAktif) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Batalkan Pengajuan</x-danger-button>
                        </form>
                    </div>
                </section>
            @else
                <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-1 border-b border-gray-200 px-6 py-4">
                        <h3 class="text-base font-semibold text-gray-900">Daftar Dosen Sesuai Bidang Minat</h3>
                        <p class="text-sm text-gray-500">Ajukan dosen pembimbing berdasarkan ketersediaan slot angkatan {{ $mahasiswa->angkatan }}.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama</th>
                                    <th scope="col" class="px-6 py-3">NIP</th>
                                    <th scope="col" class="px-6 py-3">Sisa Slot</th>
                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($dosens as $dosen)
                                    <tr class="hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">{{ $dosen->user->name }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-gray-600">{{ $dosen->nip }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $dosen->sisa_slot > 0 ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-gray-100 text-gray-500 ring-1 ring-gray-200' }}">
                                                {{ $dosen->sisa_slot }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <form method="POST" action="{{ route('mahasiswa.pengajuan.store') }}">
                                                @csrf
                                                <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">
                                                <button type="submit" @disabled($dosen->sisa_slot <= 0) class="inline-flex h-10 items-center rounded-md bg-gray-900 px-4 text-sm font-semibold text-white transition-colors hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 disabled:cursor-not-allowed disabled:bg-gray-300 disabled:text-gray-500">
                                                    {{ $dosen->sisa_slot > 0 ? 'Ajukan' : 'Slot Penuh' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-6 text-center text-gray-500" colspan="4">Belum ada dosen untuk bidang minat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif
        </div>
    </div>
</x-app-layout>
