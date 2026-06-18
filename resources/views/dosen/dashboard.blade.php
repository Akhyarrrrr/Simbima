<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-semibold leading-tight text-gray-900">Dashboard Dosen</h2>
            <p class="text-sm text-gray-500">Kelola pengajuan masuk dan mahasiswa bimbingan aktif.</p>
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

            <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h3 class="text-base font-semibold text-gray-900">Pengajuan Masuk</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th scope="col" class="px-6 py-3">Mahasiswa</th>
                                <th scope="col" class="px-6 py-3">NIM</th>
                                <th scope="col" class="px-6 py-3">Angkatan</th>
                                <th scope="col" class="px-6 py-3">Bidang Minat</th>
                                <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($pendingPengajuans as $pengajuan)
                                <tr class="hover:bg-gray-50" x-data="{ rejectOpen: false }">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">{{ $pengajuan->mahasiswa->user->name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-600">{{ $pengajuan->mahasiswa->nim }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-600">{{ $pengajuan->mahasiswa->angkatan }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-600">{{ $pengajuan->mahasiswa->bidangMinat->nama }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <form method="POST" action="{{ route('dosen.pengajuan.approve', $pengajuan) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex h-10 items-center rounded-md bg-emerald-600 px-4 text-sm font-semibold text-white transition-colors hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                                                    ACC
                                                </button>
                                            </form>
                                            <button type="button" x-on:click="rejectOpen = true" class="inline-flex h-10 items-center rounded-md bg-red-600 px-4 text-sm font-semibold text-white transition-colors hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
                                                Tolak
                                            </button>
                                        </div>

                                        <div class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/50 px-4" x-bind:class="{ 'hidden': !rejectOpen, 'flex': rejectOpen }" role="dialog" aria-modal="true" aria-labelledby="reject-title-{{ $pengajuan->id }}" x-on:keydown.escape.window="rejectOpen = false">
                                            <div x-on:click="rejectOpen = false" class="absolute inset-0"></div>
                                            <form method="POST" action="{{ route('dosen.pengajuan.reject', $pengajuan) }}" class="relative w-full max-w-lg rounded-lg bg-white p-6 text-left shadow-xl">
                                                @csrf
                                                @method('PATCH')
                                                <h4 id="reject-title-{{ $pengajuan->id }}" class="text-lg font-semibold text-gray-900">Tolak Pengajuan</h4>
                                                <p class="mt-1 text-sm text-gray-500">Berikan catatan agar mahasiswa memahami alasan penolakan.</p>
                                                <div class="mt-5">
                                                    <x-input-label for="catatan_penolakan_{{ $pengajuan->id }}" value="Catatan Penolakan" />
                                                    <textarea id="catatan_penolakan_{{ $pengajuan->id }}" name="catatan_penolakan" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                                </div>
                                                <div class="mt-6 flex justify-end gap-3">
                                                    <button type="button" x-on:click="rejectOpen = false" class="inline-flex h-10 items-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="inline-flex h-10 items-center rounded-md bg-red-600 px-4 text-sm font-semibold text-white transition-colors hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
                                                        Tolak Pengajuan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-6 text-center text-gray-500" colspan="5">Belum ada pengajuan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h3 class="text-base font-semibold text-gray-900">Mahasiswa Bimbingan Aktif</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">NIM</th>
                                <th scope="col" class="px-6 py-3">Judul TA</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($activeBimbingans as $bimbingan)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">{{ $bimbingan->mahasiswa->user->name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-600">{{ $bimbingan->mahasiswa->nim }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $bimbingan->judul_ta ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-6 text-center text-gray-500" colspan="3">Belum ada mahasiswa bimbingan aktif.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
