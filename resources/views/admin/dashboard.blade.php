<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-semibold leading-tight text-gray-900">Dashboard Admin</h2>
            <p class="text-sm text-gray-500">Ringkasan data pengajuan dan bimbingan Simbima.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Total Mahasiswa</p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $stats['total_mahasiswa'] }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Total Dosen</p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $stats['total_dosen'] }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Bimbingan Aktif</p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $stats['bimbingan_aktif'] }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Pending Pengajuan</p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $stats['pending_pengajuan'] }}</p>
                </div>
            </section>

            <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-base font-semibold text-gray-900">Akses Cepat</h3>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <a href="/admin/dosen" class="rounded-md border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-900 transition-colors hover:border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                        Kelola Dosen
                    </a>
                    <a href="/admin/mahasiswa" class="rounded-md border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-900 transition-colors hover:border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                        Kelola Mahasiswa
                    </a>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
