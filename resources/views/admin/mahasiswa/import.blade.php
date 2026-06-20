@section('eyebrow', 'IMPORT MAHASISWA')
@section('title', 'Import Mahasiswa')

<x-app-layout>
    <div class="space-y-6">
        <section class="mx-auto max-w-2xl rounded-lg border border-slate-200 bg-white p-6">
            <div>
                <h3 class="font-display text-lg font-semibold text-navy">Upload Excel/CSV Mahasiswa</h3>
                <p class="mt-1 text-sm text-slate">Gunakan file `.csv` atau `.xlsx` maksimal 5MB.</p>
            </div>

            @if ($errors->any())
                <div class="mt-5 text-rust text-xs font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.mahasiswa.import.store') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
                @csrf

                <div>
                    <x-input-label for="file" value="File Import" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
                    <input id="file" name="file" type="file" accept=".csv,.xlsx" required class="block w-full rounded-md border border-slate-300 bg-white text-sm text-navy file:mr-4 file:border-0 file:bg-navy file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white focus:border-navy focus:outline-none focus:ring-1 focus:ring-navy">
                    <p class="mt-2 text-xs leading-5 text-slate">
                        Kolom wajib: <span class="font-mono">nama</span>, <span class="font-mono">nim</span>, <span class="font-mono">email</span>, <span class="font-mono">angkatan</span>. Kolom <span class="font-mono">bidang_minat</span> opsional; jika kosong, mahasiswa memilih sendiri di dashboard.
                    </p>
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ asset('templates/mahasiswa_import_template.csv') }}" class="inline-flex items-center justify-center rounded-md border border-navy px-4 py-2 text-sm font-semibold text-navy transition-colors hover:bg-navy hover:text-white focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2" download>
                        Download Template CSV
                    </a>

                    <button type="submit" class="inline-flex items-center justify-center rounded-md bg-navy px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                        Upload & Import
                    </button>
                </div>
            </form>
        </section>

        @isset($successCount)
            <section class="mx-auto max-w-2xl rounded-lg border border-slate-200 bg-white p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate">Ringkasan Import</p>
                        <h3 class="mt-1 font-display text-lg font-semibold text-navy">
                            {{ $successCount }} berhasil, {{ count($skipped) }} dilewati
                        </h3>
                    </div>

                    @if ($credentialsFilename)
                        <a href="{{ route('admin.mahasiswa.import.download', $credentialsFilename) }}" class="inline-flex items-center justify-center rounded-md bg-navy px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                            Download Credentials CSV
                        </a>
                    @endif
                </div>

                @if ($skipped)
                    <div class="mt-5 rounded-md border border-rust/20 bg-rust/5 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-rust">Baris Dilewati</p>
                        <ul class="mt-3 space-y-2">
                            @foreach ($skipped as $skip)
                                <li class="text-sm text-rust">
                                    Baris {{ $skip['row'] }}: {{ $skip['reason'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @unless ($credentialsFilename)
                    <p class="mt-5 text-sm italic text-slate">Tidak ada credentials baru untuk diunduh.</p>
                @endunless
            </section>
        @endisset
    </div>
</x-app-layout>
