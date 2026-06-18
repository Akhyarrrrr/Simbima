<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-900">Detail Dosen</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <dl class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Nama</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $dosen->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $dosen->user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">NIP</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $dosen->nip }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Bidang Minat</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $dosen->bidangMinat->nama }}</dd>
                    </div>
                </dl>
                <div class="mt-6">
                    <a class="text-sm font-semibold text-gray-700 hover:text-gray-950 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2" href="{{ route('admin.dosen.index') }}">Kembali</a>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
