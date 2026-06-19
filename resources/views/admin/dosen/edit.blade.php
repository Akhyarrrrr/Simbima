@section('eyebrow', 'MANAJEMEN DOSEN')
@section('title', 'Edit Dosen')

<x-app-layout>
    <div class="mx-auto max-w-lg">
        <form method="POST" action="{{ route('admin.dosen.update', $dosen) }}" class="space-y-5 rounded-lg border border-slate-200 bg-white p-6">
            @csrf
            @method('PUT')

            <div>
                <h3 class="font-display text-lg font-semibold text-navy">Data Dosen</h3>
                <p class="mt-1 text-sm text-slate">Perbarui profil dosen dan slot pembimbing per angkatan.</p>
            </div>

            @include('admin.dosen.form', ['slot' => $dosen->dosenSlots->first()])

            <div class="flex justify-end gap-3 border-t border-slate-200 pt-5">
                <a href="{{ route('admin.dosen.index') }}" class="inline-flex items-center rounded-md px-4 py-2 text-sm font-semibold text-slate transition-colors hover:text-navy focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">Batal</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-navy px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
