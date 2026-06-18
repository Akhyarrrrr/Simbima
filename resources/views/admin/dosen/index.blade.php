<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-semibold leading-tight text-gray-900">Kelola Dosen</h2>
            <p class="text-sm text-gray-500">Tambah, ubah, dan atur slot pembimbing per angkatan.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex justify-end">
                <a href="{{ route('admin.dosen.create') }}" class="inline-flex h-10 items-center rounded-md bg-gray-900 px-4 text-sm font-semibold text-white transition-colors hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                    Tambah Dosen
                </a>
            </div>

            <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">NIP</th>
                                <th scope="col" class="px-6 py-3">Bidang Minat</th>
                                <th scope="col" class="px-6 py-3">Slot per Angkatan</th>
                                <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($dosens as $dosen)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">{{ $dosen->user->name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-600">{{ $dosen->user->email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-600">{{ $dosen->nip }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-600">{{ $dosen->bidangMinat->nama }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-600">
                                        @forelse ($dosen->dosenSlots as $slot)
                                            <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700 ring-1 ring-gray-200">
                                                {{ $slot->angkatan }}: {{ $slot->max_slot }}
                                            </span>
                                        @empty
                                            <span>-</span>
                                        @endforelse
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <div class="flex justify-end gap-3">
                                            <a class="text-sm font-semibold text-gray-700 hover:text-gray-950 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2" href="{{ route('admin.dosen.edit', $dosen) }}">Edit</a>
                                            <form method="POST" action="{{ route('admin.dosen.destroy', $dosen) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-6 text-center text-gray-500" colspan="6">Belum ada data dosen.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
