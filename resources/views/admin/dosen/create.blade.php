<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-semibold leading-tight text-gray-900">Tambah Dosen</h2>
            <p class="text-sm text-gray-500">Buat akun dosen sekaligus slot pembimbing untuk satu angkatan.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.dosen.store') }}" class="space-y-5 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                @csrf

                @include('admin.dosen.form', ['dosen' => null, 'slot' => null])

                <div class="flex justify-end gap-3 border-t border-gray-200 pt-5">
                    <a href="{{ route('admin.dosen.index') }}" class="inline-flex h-10 items-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Batal</a>
                    <button type="submit" class="inline-flex h-10 items-center rounded-md bg-gray-900 px-4 text-sm font-semibold text-white transition-colors hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
