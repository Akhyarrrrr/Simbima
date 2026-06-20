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

    @php
        $defaultSlots = $dosen?->dosenSlots?->sortByDesc('angkatan')->values()->map(fn ($slot) => [
            'angkatan' => $slot->angkatan,
            'max_slot' => $slot->max_slot,
        ])->all() ?: [['angkatan' => 2021, 'max_slot' => 10]];
        $formSlots = old('slots', $defaultSlots);
    @endphp

    <div x-data="{ slots: @js($formSlots) }" class="rounded-lg border border-slate-200 bg-paper/50 p-4">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Slot Per Angkatan</p>
                <p class="mt-1 text-sm text-slate">Contoh: angkatan 2021 punya 10 slot, angkatan 2022 bisa diisi terpisah.</p>
            </div>
            <button type="button" x-on:click="slots.push({ angkatan: new Date().getFullYear(), max_slot: 10 })" class="inline-flex items-center rounded-md border border-navy px-3 py-1.5 text-sm font-semibold text-navy transition-colors hover:bg-navy hover:text-white focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                Tambah
            </button>
        </div>

        <div class="mt-4 space-y-3">
            <template x-for="(slot, index) in slots" :key="index">
                <div class="grid gap-3 rounded-md bg-white p-3 sm:grid-cols-[1fr_1fr_auto]">
                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate">Angkatan</label>
                        <input type="number" x-bind:name="`slots[${index}][angkatan]`" x-model="slot.angkatan" required min="2000" max="2100" class="block w-full rounded-md border-slate-300 text-sm text-navy shadow-sm focus:border-navy focus:ring-navy">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate">Slot</label>
                        <input type="number" x-bind:name="`slots[${index}][max_slot]`" x-model="slot.max_slot" required min="0" max="255" class="block w-full rounded-md border-slate-300 text-sm text-navy shadow-sm focus:border-navy focus:ring-navy">
                    </div>
                    <div class="flex items-end">
                        <button type="button" x-on:click="slots.splice(index, 1)" x-bind:disabled="slots.length === 1" class="inline-flex h-10 items-center rounded-md border border-rust px-3 text-sm font-semibold text-rust transition-colors hover:bg-rust hover:text-white disabled:cursor-not-allowed disabled:border-slate-200 disabled:text-slate-300 disabled:hover:bg-white">
                            Hapus
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
