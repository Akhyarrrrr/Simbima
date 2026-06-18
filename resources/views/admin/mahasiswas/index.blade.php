<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Mahasiswa</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-green-100 text-green-800 p-4 rounded">{{ session('status') }}</div>
            @endif

            <a href="{{ route('admin.mahasiswa.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md">Tambah Mahasiswa</a>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4">Nama</th>
                            <th class="p-4">NIM</th>
                            <th class="p-4">Angkatan</th>
                            <th class="p-4">Bidang Minat</th>
                            <th class="p-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswas as $mahasiswa)
                            <tr class="border-t">
                                <td class="p-4">{{ $mahasiswa->user->name }}</td>
                                <td class="p-4">{{ $mahasiswa->nim }}</td>
                                <td class="p-4">{{ $mahasiswa->angkatan }}</td>
                                <td class="p-4">{{ $mahasiswa->bidangMinat->nama }}</td>
                                <td class="p-4 flex gap-2">
                                    <a class="text-blue-600" href="{{ route('admin.mahasiswa.show', $mahasiswa) }}">Detail</a>
                                    <a class="text-blue-600" href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-4" colspan="5">Belum ada mahasiswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
