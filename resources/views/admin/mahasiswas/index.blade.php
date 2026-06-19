@section('eyebrow', 'MANAJEMEN MAHASISWA')

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-2xl font-semibold text-navy">Kelola Mahasiswa</h2>
                <p class="mt-1 text-sm text-slate">Tambah dan ubah data mahasiswa bimbingan tugas akhir.</p>
            </div>
            <a href="{{ route('admin.mahasiswa.create') }}" class="inline-flex items-center justify-center rounded-md bg-navy px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                Tambah Mahasiswa
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-md border border-forest/20 bg-forest/10 px-4 py-3 text-sm font-medium text-forest">
                {{ session('status') }}
            </div>
        @endif

        <section class="overflow-hidden rounded-lg border border-slate-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse text-left text-sm">
                    <thead class="bg-navy/5 text-xs font-semibold uppercase tracking-wide text-navy">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">NIM</th>
                            <th scope="col" class="px-6 py-3">Angkatan</th>
                            <th scope="col" class="px-6 py-3">Bidang Minat</th>
                            <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse ($mahasiswas as $mahasiswa)
                            <tr class="border-b border-slate-100 last:border-b-0 hover:bg-paper/60">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-navy">{{ $mahasiswa->user->name }}</td>
                                <td class="whitespace-nowrap px-6 py-4 font-mono text-sm text-slate">{{ $mahasiswa->nim }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate">{{ $mahasiswa->angkatan }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate">{{ $mahasiswa->bidangMinat->nama }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a class="inline-flex items-center rounded-md border border-navy px-3 py-1.5 text-sm font-semibold text-navy transition-colors hover:bg-navy hover:text-white focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2" href="{{ route('admin.mahasiswa.show', $mahasiswa) }}">Detail</a>
                                        <a class="inline-flex items-center rounded-md border border-navy px-3 py-1.5 text-sm font-semibold text-navy transition-colors hover:bg-navy hover:text-white focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2" href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}">Edit</a>
                                        <form method="POST" action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="inline-flex items-center rounded-md border border-rust px-3 py-1.5 text-sm font-semibold text-rust transition-colors hover:bg-rust hover:text-white focus:outline-none focus:ring-2 focus:ring-rust focus:ring-offset-2" type="submit">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-6 text-center text-slate" colspan="5">Belum ada mahasiswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
