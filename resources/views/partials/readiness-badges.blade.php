@php
    $items = [
        ['label' => 'Sempro', 'enabled' => $bimbingan->boleh_sempro],
        ['label' => 'Semhas', 'enabled' => $bimbingan->boleh_semhas],
        ['label' => 'Sidang', 'enabled' => $bimbingan->boleh_sidang],
    ];
@endphp

<div class="grid gap-3 sm:grid-cols-3">
    @foreach ($items as $item)
        <div class="rounded-lg border px-4 py-3 {{ $item['enabled'] ? 'border-forest bg-forest/10 text-forest' : 'border-slate-200 bg-slate-50 text-slate-400' }}">
            <p class="text-xs font-semibold uppercase tracking-wide">{{ $item['label'] }}</p>
            <p class="mt-1 text-sm font-semibold">{{ $item['enabled'] ? 'Diizinkan' : 'Belum diizinkan' }}</p>
        </div>
    @endforeach
</div>
