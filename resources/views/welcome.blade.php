<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="SIMBIMA adalah Sistem Informasi Bimbingan Mahasiswa untuk mengelola pengajuan dosen pembimbing, catatan bimbingan, dan progres tugas akhir.">

        <title>Simbima</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('USK-logo.svg') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-paper text-navy">
        <main class="relative min-h-[100dvh] overflow-hidden">
            <div class="home-grid" aria-hidden="true"></div>

            <header class="relative z-10 px-6 py-5">
                <nav class="flex items-center justify-between max-w-6xl mx-auto">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 rounded-full focus:outline-none focus:ring-2 focus:ring-forest focus:ring-offset-4">
                        <img src="{{ asset('USK-logo.svg') }}" alt="Logo USK" class="w-auto h-11">
                        <span class="text-lg font-semibold tracking-tight">SIMBIMA</span>
                    </a>

                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-navy px-5 py-2.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-forest focus:outline-none focus:ring-2 focus:ring-forest focus:ring-offset-4 active:translate-y-0">
                        Masuk
                    </a>
                </nav>
            </header>

            <section class="relative z-10 px-6 pb-14 pt-6 sm:pt-10">
                <div class="grid items-center max-w-6xl gap-12 mx-auto lg:grid-cols-[1.02fr_0.98fr]">
                    <div class="max-w-2xl animate-home-rise">
                        <p class="inline-flex rounded-full border border-forest/20 bg-white/70 px-4 py-2 text-sm font-semibold text-forest shadow-sm backdrop-blur">
                            Sistem Bimbingan Mahasiswa Akhir
                        </p>

                        <h1 class="mt-7 text-4xl font-semibold leading-tight tracking-tight sm:text-6xl lg:text-7xl">
                            Bimbingan tugas akhir yang lebih jelas, cepat, dan terarah.
                        </h1>

                        <p class="max-w-xl mt-6 text-lg leading-8 text-slate">
                            SIMBIMA membantu mahasiswa, dosen, dan admin mengelola pengajuan pembimbing, slot, catatan, dan progres tugas akhir dalam satu sistem.
                        </p>

                        <div class="flex flex-col gap-3 mt-8 sm:flex-row">
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-forest px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-forest/20 transition hover:-translate-y-0.5 hover:bg-navy focus:outline-none focus:ring-2 focus:ring-forest focus:ring-offset-4 active:translate-y-0">
                                Masuk ke SIMBIMA
                            </a>
                            <a href="#fitur" class="inline-flex items-center justify-center rounded-full border border-navy/15 bg-white/75 px-6 py-3 text-sm font-semibold text-navy transition hover:-translate-y-0.5 hover:border-forest/30 hover:text-forest focus:outline-none focus:ring-2 focus:ring-forest focus:ring-offset-4 active:translate-y-0">
                                Lihat fitur
                            </a>
                        </div>

                        <div class="mt-9 grid max-w-xl grid-cols-2 gap-3 text-sm text-slate sm:grid-cols-4">
                            <span class="rounded-2xl bg-white/75 px-4 py-3 shadow-sm">Laravel 11</span>
                            <span class="rounded-2xl bg-white/75 px-4 py-3 shadow-sm">MySQL</span>
                            <span class="rounded-2xl bg-white/75 px-4 py-3 shadow-sm">Tailwind CSS</span>
                            <span class="rounded-2xl bg-white/75 px-4 py-3 shadow-sm">Railway</span>
                        </div>
                    </div>

                    <div class="home-showcase relative mx-auto w-full max-w-[560px] animate-home-rise" style="--delay: 120ms">
                        <div class="rounded-[2rem] border border-navy/10 bg-white/80 p-4 shadow-2xl shadow-navy/10 backdrop-blur">
                            <div class="rounded-[1.5rem] bg-navy p-5 text-white">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-sm text-white/60">Dashboard SIMBIMA</p>
                                        <p class="mt-1 text-xl font-semibold">Alur bimbingan aktif</p>
                                    </div>
                                    <img src="{{ asset('USK-logo.svg') }}" alt="Logo USK" class="h-10 w-auto rounded-full bg-white p-1">
                                </div>

                                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                    <article class="home-role-card rounded-3xl bg-white p-5 text-navy">
                                        <p class="text-xs font-semibold text-forest">Mahasiswa</p>
                                        <h2 class="mt-3 text-lg font-semibold">Ajukan dosen pembimbing</h2>
                                        <p class="mt-3 text-sm leading-6 text-slate">Pilih bidang minat, kirim pengajuan, lalu pantau status sampai bimbingan aktif.</p>
                                    </article>

                                    <article class="home-role-card rounded-3xl bg-[#F5E7B8] p-5 text-navy" style="--delay: 180ms">
                                        <p class="text-xs font-semibold text-rust">Dosen</p>
                                        <h2 class="mt-3 text-lg font-semibold">Tinjau dan beri arahan</h2>
                                        <p class="mt-3 text-sm leading-6 text-slate">Terima pengajuan, tambahkan catatan, ubah status, dan bantu progres mahasiswa.</p>
                                    </article>
                                </div>

                                <div class="mt-4 rounded-3xl bg-white/10 p-4">
                                    <div class="grid grid-cols-4 gap-2 text-center text-xs text-white/70">
                                        <span class="rounded-full bg-white/10 px-2 py-2">Minat</span>
                                        <span class="rounded-full bg-white/10 px-2 py-2">Pengajuan</span>
                                        <span class="rounded-full bg-white/10 px-2 py-2">Review</span>
                                        <span class="rounded-full bg-forest px-2 py-2 font-semibold text-white">Aktif</span>
                                    </div>
                                    <div class="mt-4 h-2 overflow-hidden rounded-full bg-white/10">
                                        <div class="home-progress h-full rounded-full bg-gold"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -bottom-5 left-5 right-5 rounded-3xl border border-forest/15 bg-white px-5 py-4 shadow-xl shadow-navy/10">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <p class="text-sm font-semibold text-navy">Admin menjaga data, slot, dan statistik tetap rapi.</p>
                                <span class="rounded-full bg-forest/10 px-3 py-1 text-xs font-semibold text-forest">Siap demo</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="fitur" class="relative z-10 px-6 py-16 sm:py-20">
                <div class="max-w-6xl mx-auto">
                    <div class="max-w-3xl">
                        <h2 class="text-3xl font-semibold tracking-tight sm:text-5xl">Fitur yang langsung terasa setelah login.</h2>
                        <p class="mt-5 text-lg leading-8 text-slate">
                            Setiap role masuk ke ruang kerja yang berbeda, jadi alur bimbingan tidak bercampur dan mudah dipantau.
                        </p>
                    </div>

                    <div class="mt-10 grid gap-4 lg:grid-cols-6">
                        <article class="home-feature lg:col-span-3">
                            <span>Mahasiswa</span>
                            <h3>Mulai dari minat sampai bimbingan aktif</h3>
                            <p>Mahasiswa memilih bidang minat, mengajukan dosen, melihat status persetujuan, dan memperbarui progres tugas akhir.</p>
                        </article>

                        <article class="home-feature home-feature-dark lg:col-span-3">
                            <span>Dosen</span>
                            <h3>Keputusan pengajuan lebih cepat</h3>
                            <p>Dosen meninjau pengajuan, menerima atau menolak dengan catatan, lalu memantau proses bimbingan mahasiswa.</p>
                        </article>

                        <article class="home-feature home-feature-gold lg:col-span-2">
                            <span>Admin</span>
                            <h3>Data akademik tertata</h3>
                            <p>Kelola dosen, mahasiswa, slot, password, dan import data mahasiswa.</p>
                        </article>

                        <article class="home-feature lg:col-span-2">
                            <span>Statistik</span>
                            <h3>Distribusi dosen terbaca</h3>
                            <p>Pantau rekap bimbingan dan export statistik dosen saat dibutuhkan.</p>
                        </article>

                        <article class="home-feature home-feature-forest lg:col-span-2">
                            <span>Notifikasi</span>
                            <h3>Perubahan status tidak terlewat</h3>
                            <p>Pengajuan baru, diterima, atau ditolak muncul sebagai notifikasi di akun terkait.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section class="relative z-10 px-6 pb-20">
                <div class="max-w-6xl mx-auto rounded-[2rem] bg-navy px-6 py-10 text-white shadow-2xl shadow-navy/15 sm:px-10">
                    <h2 class="max-w-2xl text-3xl font-semibold tracking-tight sm:text-4xl">Tujuannya sederhana: bimbingan lebih transparan dari awal sampai selesai.</h2>

                    <div class="mt-8 grid gap-3 md:grid-cols-5">
                        @foreach (['Pilih minat', 'Ajukan dosen', 'Review dosen', 'Bimbingan aktif', 'Selesai'] as $step)
                            <div class="rounded-2xl border border-white/10 bg-white/10 px-4 py-4 text-sm font-semibold backdrop-blur">
                                {{ $step }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
