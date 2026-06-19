@if ($errors->any())
    <div class="text-rust mt-1 text-xs font-medium">
        {{ $errors->first() }}
    </div>
@endif

<div class="space-y-5">
    <div>
        <x-input-label for="name" value="Nama" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
        <x-text-input id="name" name="name" class="block w-full rounded-md border-slate-300 focus:border-navy focus:ring-navy" value="{{ old('name', $mahasiswa?->user?->name) }}" required />
    </div>

    <div>
        <x-input-label for="email" value="Email" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
        <x-text-input id="email" name="email" type="email" class="block w-full rounded-md border-slate-300 focus:border-navy focus:ring-navy" value="{{ old('email', $mahasiswa?->user?->email) }}" required />
    </div>

    <div>
        <x-input-label for="password" value="Password" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
        <x-text-input id="password" name="password" type="password" class="block w-full rounded-md border-slate-300 focus:border-navy focus:ring-navy" :required="! $mahasiswa" />
    </div>

    <div>
        <x-input-label for="nim" value="NIM" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
        <x-text-input id="nim" name="nim" class="block w-full rounded-md border-slate-300 font-mono focus:border-navy focus:ring-navy" value="{{ old('nim', $mahasiswa?->nim) }}" required />
    </div>

    <div>
        <x-input-label for="angkatan" value="Angkatan" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
        <x-text-input id="angkatan" name="angkatan" type="number" class="block w-full rounded-md border-slate-300 focus:border-navy focus:ring-navy" value="{{ old('angkatan', $mahasiswa?->angkatan ?? 2021) }}" required />
    </div>

    <div>
        <x-input-label for="bidang_minat_id" value="Bidang Minat" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
        <select id="bidang_minat_id" name="bidang_minat_id" class="block w-full rounded-md border-slate-300 text-sm text-navy shadow-sm focus:border-navy focus:ring-navy">
            <option value="">Belum dipilih mahasiswa</option>
            @foreach ($bidangMinats as $bidangMinat)
                <option value="{{ $bidangMinat->id }}" @selected(old('bidang_minat_id', $mahasiswa?->bidang_minat_id) == $bidangMinat->id)>
                    {{ $bidangMinat->nama }}
                </option>
            @endforeach
        </select>
    </div>
</div>
