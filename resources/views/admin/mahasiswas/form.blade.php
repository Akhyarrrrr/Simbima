@if ($errors->any())
    <div class="bg-red-100 text-red-800 p-4 rounded">{{ $errors->first() }}</div>
@endif

<div>
    <x-input-label for="name" value="Nama" />
    <x-text-input id="name" name="name" class="mt-1 block w-full" value="{{ old('name', $mahasiswa?->user?->name) }}" required />
</div>

<div>
    <x-input-label for="email" value="Email" />
    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $mahasiswa?->user?->email) }}" required />
</div>

<div>
    <x-input-label for="password" value="Password" />
    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" :required="! $mahasiswa" />
</div>

<div>
    <x-input-label for="nim" value="NIM" />
    <x-text-input id="nim" name="nim" class="mt-1 block w-full" value="{{ old('nim', $mahasiswa?->nim) }}" required />
</div>

<div>
    <x-input-label for="angkatan" value="Angkatan" />
    <x-text-input id="angkatan" name="angkatan" type="number" class="mt-1 block w-full" value="{{ old('angkatan', $mahasiswa?->angkatan ?? 2021) }}" required />
</div>

<div>
    <x-input-label for="bidang_minat_id" value="Bidang Minat" />
    <select id="bidang_minat_id" name="bidang_minat_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        @foreach ($bidangMinats as $bidangMinat)
            <option value="{{ $bidangMinat->id }}" @selected(old('bidang_minat_id', $mahasiswa?->bidang_minat_id) == $bidangMinat->id)>
                {{ $bidangMinat->nama }}
            </option>
        @endforeach
    </select>
</div>
