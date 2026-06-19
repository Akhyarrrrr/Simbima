@if ($errors->any())
    <div class="text-rust mt-1 text-xs font-medium">
        {{ $errors->first() }}
    </div>
@endif

<div class="space-y-5">
    <div>
        <x-input-label for="name" value="Nama" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
        <x-text-input id="name" name="name" class="block w-full rounded-md border-slate-300 focus:border-navy focus:ring-navy" value="{{ old('name', $dosen?->user?->name) }}" required />
    </div>

    <div>
        <x-input-label for="email" value="Email" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
        <x-text-input id="email" name="email" type="email" class="block w-full rounded-md border-slate-300 focus:border-navy focus:ring-navy" value="{{ old('email', $dosen?->user?->email) }}" required />
    </div>

    <div>
        <x-input-label for="nip" value="NIP" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
        <x-text-input id="nip" name="nip" class="block w-full rounded-md border-slate-300 font-mono focus:border-navy focus:ring-navy" value="{{ old('nip', $dosen?->nip) }}" required />
    </div>

    <div>
        <x-input-label for="bidang_minat_id" value="Bidang Minat" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
        <select id="bidang_minat_id" name="bidang_minat_id" class="block w-full rounded-md border-slate-300 text-sm text-navy shadow-sm focus:border-navy focus:ring-navy" required>
            @foreach ($bidangMinats as $bidangMinat)
                <option value="{{ $bidangMinat->id }}" @selected(old('bidang_minat_id', $dosen?->bidang_minat_id) == $bidangMinat->id)>
                    {{ $bidangMinat->nama }}
                </option>
            @endforeach
        </select>
    </div>

    @if (! $dosen)
        <div>
            <x-input-label for="password" value="Password" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
            <x-text-input id="password" name="password" type="password" class="block w-full rounded-md border-slate-300 focus:border-navy focus:ring-navy" required />
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-input-label for="angkatan" value="Angkatan Slot" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
            <x-text-input id="angkatan" name="angkatan" type="number" class="block w-full rounded-md border-slate-300 focus:border-navy focus:ring-navy" value="{{ old('angkatan', $slot?->angkatan ?? 2021) }}" required />
        </div>

        <div>
            <x-input-label for="max_slot" value="Max Slot" class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate" />
            <x-text-input id="max_slot" name="max_slot" type="number" class="block w-full rounded-md border-slate-300 focus:border-navy focus:ring-navy" value="{{ old('max_slot', $slot?->max_slot ?? 10) }}" required />
        </div>
    </div>
</div>
