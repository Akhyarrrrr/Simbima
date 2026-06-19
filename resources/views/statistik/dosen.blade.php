@section('eyebrow', 'STATISTIK DOSEN')
@section('title', 'Beban Bimbingan Dosen')

<x-app-layout>
    <div class="space-y-6">
        <section class="grid gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-slate-200 border-t-2 border-t-gold bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Total Dosen</p>
                <p class="mt-3 font-display text-3xl font-semibold text-navy">{{ $stats['total_dosen'] }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 border-t-2 border-t-gold bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Bimbingan Aktif</p>
                <p class="mt-3 font-display text-3xl font-semibold text-navy">{{ $stats['total_bimbingan_aktif'] }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 border-t-2 border-t-gold bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Rata-rata Beban</p>
                <p class="mt-3 font-display text-3xl font-semibold text-navy">{{ $stats['rata_rata_beban'] }}</p>
            </div>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Visualisasi</p>
                <h3 class="mt-1 font-display text-lg font-semibold text-navy">Jumlah Mahasiswa Bimbingan Aktif</h3>
                <p class="mt-1 text-sm text-slate">Dihitung berdasarkan dosen sebagai pembimbing utama.</p>
            </div>

            <div class="h-[520px]">
                <canvas id="dosenWorkloadChart"></canvas>
            </div>
        </section>

        <section class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-gold/30 px-6 py-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate">Detail Beban</p>
                <h3 class="mt-1 font-display text-lg font-semibold text-navy">Tabel Distribusi Bimbingan</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse text-left text-sm">
                    <thead class="bg-navy/5 text-xs font-semibold uppercase tracking-wide text-navy">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">NIP</th>
                            <th scope="col" class="px-6 py-3">Bidang Minat</th>
                            <th scope="col" class="px-6 py-3">Bimbingan Aktif</th>
                            <th scope="col" class="px-6 py-3">Max Slot</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($dosens as $dosen)
                            @php
                                $statusClass = match ($dosen['status']) {
                                    'Overload' => 'border-rust bg-rust/10 text-rust',
                                    'Penuh' => 'border-gold bg-gold/10 text-gold',
                                    default => 'border-forest bg-forest/10 text-forest',
                                };
                            @endphp

                            <tr class="border-b border-slate-100 last:border-b-0 hover:bg-paper/60">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-navy">{{ $dosen['nama'] }}</td>
                                <td class="whitespace-nowrap px-6 py-4 font-mono text-sm text-slate">{{ $dosen['nip'] }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate">{{ $dosen['bidang_minat'] }}</td>
                                <td class="whitespace-nowrap px-6 py-4 font-mono text-sm font-semibold text-navy">{{ $dosen['bimbingan_aktif_count'] }}</td>
                                <td class="whitespace-nowrap px-6 py-4 font-mono text-sm text-slate">{{ $dosen['max_slot'] }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="rounded-full border px-2.5 py-1 text-xs font-semibold uppercase tracking-wide {{ $statusClass }}">
                                        {{ $dosen['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const workloadData = @json($chartData);
        const workloadCanvas = document.getElementById('dosenWorkloadChart');

        if (workloadCanvas) {
            new Chart(workloadCanvas, {
                type: 'bar',
                data: {
                    labels: workloadData.labels,
                    datasets: [{
                        label: 'Mahasiswa Bimbingan Aktif',
                        data: workloadData.values,
                        backgroundColor: workloadData.colors,
                        borderRadius: 6,
                        barThickness: 18,
                    }],
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                            },
                            grid: {
                                color: 'rgba(92, 100, 112, 0.16)',
                            },
                        },
                        y: {
                            grid: {
                                display: false,
                            },
                        },
                    },
                },
            });
        }
    </script>
</x-app-layout>
