@section('eyebrow', 'MANAJEMEN DOSEN')

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-2xl font-semibold text-navy">Kelola Dosen</h2>
                <p class="mt-1 text-sm text-slate">Tambah, ubah, dan atur slot pembimbing per angkatan.</p>
            </div>
            <a href="{{ route('admin.dosen.create') }}" class="inline-flex items-center justify-center rounded-md bg-navy px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                Tambah Dosen
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
                            <th scope="col" class="px-6 py-3">NIP</th>
                            <th scope="col" class="px-6 py-3">Bidang Minat</th>
                            <th scope="col" class="px-6 py-3">Slot</th>
                            <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse ($dosens as $dosen)
                            @php
                                $latestSlot = $dosen->dosenSlots->sortByDesc('angkatan')->first();
                            @endphp

                            <tr class="border-b border-slate-100 last:border-b-0 hover:bg-paper/60">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-navy">{{ $dosen->user->name }}</td>
                                <td class="whitespace-nowrap px-6 py-4 font-mono text-sm text-slate">{{ $dosen->nip }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate">{{ $dosen->bidangMinat->nama }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate">
                                    @if ($latestSlot)
                                        <span class="inline-flex rounded-full bg-gold/10 px-2.5 py-1 text-xs font-semibold text-gold ring-1 ring-gold/30">
                                            {{ $latestSlot->angkatan }}: {{ $latestSlot->max_slot }}
                                        </span>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a class="inline-flex items-center rounded-md border border-navy px-3 py-1.5 text-sm font-semibold text-navy transition-colors hover:bg-navy hover:text-white focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2" href="{{ route('admin.dosen.edit', $dosen) }}">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.dosen.destroy', $dosen) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-md border border-rust px-3 py-1.5 text-sm font-semibold text-rust transition-colors hover:bg-rust hover:text-white focus:outline-none focus:ring-2 focus:ring-rust focus:ring-offset-2">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-6 text-center text-slate" colspan="5">Belum ada data dosen.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
