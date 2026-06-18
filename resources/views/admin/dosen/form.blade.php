@if ($errors->any())
    <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
        {{ $errors->first() }}
    </div>
@endif

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <x-input-label for="name" value="Nama" />
        <x-text-input id="name" name="name" class="mt-1 block h-10 w-full" value="{{ old('name', $dosen?->user?->name) }}" required />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block h-10 w-full" value="{{ old('email', $dosen?->user?->email) }}" required />
    </div>
</div>

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <x-input-label for="nip" value="NIP" />
        <x-text-input id="nip" name="nip" class="mt-1 block h-10 w-full" value="{{ old('nip', $dosen?->nip) }}" required />
    </div>

    <div>
        <x-input-label for="bidang_minat_id" value="Bidang Minat" />
        <select id="bidang_minat_id" name="bidang_minat_id" class="mt-1 block h-10 w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            @foreach ($bidangMinats as $bidangMinat)
                <option value="{{ $bidangMinat->id }}" @selected(old('bidang_minat_id', $dosen?->bidang_minat_id) == $bidangMinat->id)>
                    {{ $bidangMinat->nama }}
                </option>
            @endforeach
        </select>
    </div>
</div>

@if (! $dosen)
    <div>
        <x-input-label for="password" value="Password" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block h-10 w-full" required />
    </div>
@endif

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <x-input-label for="angkatan" value="Angkatan Slot" />
        <x-text-input id="angkatan" name="angkatan" type="number" class="mt-1 block h-10 w-full" value="{{ old('angkatan', $slot?->angkatan ?? 2021) }}" required />
    </div>

    <div>
        <x-input-label for="max_slot" value="Max Slot" />
        <x-text-input id="max_slot" name="max_slot" type="number" class="mt-1 block h-10 w-full" value="{{ old('max_slot', $slot?->max_slot ?? 10) }}" required />
    </div>
</div>
