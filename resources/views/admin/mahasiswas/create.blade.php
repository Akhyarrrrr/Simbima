<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Mahasiswa</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.mahasiswa.store') }}" class="bg-white p-6 shadow-sm sm:rounded-lg space-y-4">
                @csrf

                @include('admin.mahasiswas.form', ['mahasiswa' => null])

                <x-primary-button>Simpan</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
