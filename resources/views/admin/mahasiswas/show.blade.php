<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Mahasiswa</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg space-y-2">
                <p>Nama: {{ $mahasiswa->user->name }}</p>
                <p>Email: {{ $mahasiswa->user->email }}</p>
                <p>NIM: {{ $mahasiswa->nim }}</p>
                <p>Angkatan: {{ $mahasiswa->angkatan }}</p>
                <p>Bidang Minat: {{ $mahasiswa->bidangMinat->nama }}</p>
                <a class="text-blue-600" href="{{ route('admin.mahasiswa.index') }}">Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>
