<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="SIMBIMA adalah Sistem Informasi Bimbingan Mahasiswa Akhir untuk mendukung pengajuan dosen pembimbing, pencatatan bimbingan, dan pemantauan progres tugas akhir di lingkungan departemen.">

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
                        <span class="text-lg font-semibold tracking-wide font-display">SIMBIMA</span>
                    </a>

                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md bg-navy px-5 py-2.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-forest focus:outline-none focus:ring-2 focus:ring-forest focus:ring-offset-4 active:translate-y-0">
                        Masuk
                    </a>
                </nav>
            </header>

            <section class="relative z-10 px-6 pb-14 pt-6 sm:pt-10">
                <div class="grid items-center max-w-6xl gap-12 mx-auto lg:grid-cols-[1.02fr_0.98fr]">
                    <div class="max-w-2xl animate-home-rise">
                        <p class="inline-flex rounded-md border border-gold/40 bg-white/80 px-4 py-2 text-sm font-semibold text-forest shadow-sm backdrop-blur">
                            Sistem Bimbingan Mahasiswa Akhir
                        </p>

                        <h1 class="mt-7 font-display text-4xl font-semibold leading-tight tracking-tight sm:text-5xl lg:text-6xl">
                            Sistem Informasi Bimbingan Tugas Akhir Departemen
                        </h1>

                        <p class="max-w-xl mt-6 text-lg leading-8 text-slate">
                            SIMBIMA mendukung pengajuan dosen pembimbing, pengelolaan slot, pencatatan bimbingan, dan pemantauan progres tugas akhir secara tertib.
                        </p>

                        <div class="flex flex-col gap-3 mt-8 sm:flex-row">
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md bg-forest px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-forest/20 transition hover:-translate-y-0.5 hover:bg-navy focus:outline-none focus:ring-2 focus:ring-forest focus:ring-offset-4 active:translate-y-0">
                                Masuk ke SIMBIMA
                            </a>
                            <a href="#fitur" class="inline-flex items-center justify-center rounded-md border border-navy/15 bg-white/75 px-6 py-3 text-sm font-semibold text-navy transition hover:-translate-y-0.5 hover:border-forest/30 hover:text-forest focus:outline-none focus:ring-2 focus:ring-forest focus:ring-offset-4 active:translate-y-0">
                                Lihat fitur
                            </a>
                        </div>

                    </div>

                    <div class="home-showcase relative mx-auto w-full max-w-[560px] animate-home-rise" style="--delay: 120ms">
                        <div class="rounded-xl border border-slate-200 bg-white/85 p-4 shadow-2xl shadow-navy/10 backdrop-blur">
                            <div class="rounded-lg bg-navy p-5 text-white">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-sm text-white/60">Dashboard SIMBIMA</p>
                                        <p class="mt-1 font-display text-xl font-semibold">Alur bimbingan aktif</p>
                                    </div>
                                    <img src="{{ asset('USK-logo.svg') }}" alt="Logo USK" class="h-10 w-auto rounded-full bg-white p-1">
                                </div>

                                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                    <article class="home-role-card rounded-lg bg-white p-5 text-navy">
                                        <p class="text-xs font-semibold text-forest">Mahasiswa</p>
                                        <h2 class="mt-3 font-display text-lg font-semibold">Ajukan dosen pembimbing</h2>
                                        <p class="mt-3 text-sm leading-6 text-slate">Mahasiswa memilih bidang minat, mengirim pengajuan, dan memantau status persetujuan.</p>
                                    </article>

                                    <article class="home-role-card rounded-lg bg-[#F5E7B8] p-5 text-navy" style="--delay: 180ms">
                                        <p class="text-xs font-semibold text-rust">Dosen</p>
                                        <h2 class="mt-3 font-display text-lg font-semibold">Tinjau dan beri arahan</h2>
                                        <p class="mt-3 text-sm leading-6 text-slate">Dosen meninjau pengajuan, memberi keputusan, dan mencatat perkembangan bimbingan.</p>
                                    </article>
                                </div>

                                <div class="mt-4 rounded-lg bg-white/10 p-4">
                                    <div class="grid grid-cols-4 gap-2 text-center text-xs text-white/70">
                                        <span class="rounded-md bg-white/10 px-2 py-2">Minat</span>
                                        <span class="rounded-md bg-white/10 px-2 py-2">Pengajuan</span>
                                        <span class="rounded-md bg-white/10 px-2 py-2">Tinjau</span>
                                        <span class="rounded-md bg-forest px-2 py-2 font-semibold text-white">Aktif</span>
                                    </div>
                                    <div class="mt-4 h-2 overflow-hidden rounded-md bg-white/10">
                                        <div class="home-progress h-full rounded-md bg-gold"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -bottom-5 left-5 right-5 rounded-lg border border-forest/15 bg-white px-5 py-4 shadow-xl shadow-navy/10">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <p class="text-sm font-semibold text-navy">Admin mengelola data akademik, slot dosen, dan rekap bimbingan.</p>
                                <span class="rounded-md bg-forest/10 px-3 py-1 text-xs font-semibold text-forest">Layanan akademik</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="fitur" class="relative z-10 px-6 py-16 sm:py-20">
                <div class="max-w-6xl mx-auto">
                    <div class="max-w-3xl">
                        <h2 class="font-display text-3xl font-semibold tracking-tight sm:text-5xl">Fitur utama setelah pengguna masuk.</h2>
                        <p class="mt-5 text-lg leading-8 text-slate">
                            Setiap peran memiliki ruang kerja tersendiri agar proses administrasi, pengajuan, dan pemantauan bimbingan berjalan tertib.
                        </p>
                    </div>

                    <div class="mt-10 grid gap-4 lg:grid-cols-6">
                        <article class="home-feature lg:col-span-3">
                            <span>Mahasiswa</span>
                            <h3>Pengajuan pembimbing lebih tertata</h3>
                            <p>Mahasiswa memilih bidang minat, mengajukan dosen pembimbing, melihat status persetujuan, dan memperbarui progres tugas akhir.</p>
                        </article>

                        <article class="home-feature home-feature-dark lg:col-span-3">
                            <span>Dosen</span>
                            <h3>Keputusan pengajuan terdokumentasi</h3>
                            <p>Dosen meninjau pengajuan, memberikan keputusan dengan catatan, lalu memantau proses bimbingan mahasiswa.</p>
                        </article>

                        <article class="home-feature home-feature-gold lg:col-span-2">
                            <span>Admin</span>
                            <h3>Data akademik dikelola terpusat</h3>
                            <p>Admin mengelola data dosen, mahasiswa, slot bimbingan, akun pengguna, dan impor data mahasiswa.</p>
                        </article>

                        <article class="home-feature lg:col-span-2">
                            <span>Statistik</span>
                            <h3>Distribusi bimbingan dapat dipantau</h3>
                            <p>Rekap bimbingan dosen tersedia untuk membantu pemantauan beban dan kebutuhan laporan departemen.</p>
                        </article>

                        <article class="home-feature home-feature-forest lg:col-span-2">
                            <span>Notifikasi</span>
                            <h3>Perubahan status tersampaikan</h3>
                            <p>Pengajuan baru, diterima, atau ditolak tercatat sebagai notifikasi pada akun pengguna terkait.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section class="relative z-10 px-6 pb-20">
                <div class="max-w-6xl mx-auto rounded-xl bg-navy px-6 py-10 text-white shadow-2xl shadow-navy/15 sm:px-10">
                    <h2 class="max-w-2xl font-display text-3xl font-semibold tracking-tight sm:text-4xl">Tujuannya jelas: proses bimbingan tugas akhir tercatat dari pengajuan sampai selesai.</h2>

                    <div class="mt-8 grid gap-3 md:grid-cols-5">
                        @foreach (['Pilih minat', 'Ajukan dosen', 'Tinjau dosen', 'Bimbingan aktif', 'Selesai'] as $step)
                            <div class="rounded-lg border border-white/10 bg-white/10 px-4 py-4 text-sm font-semibold backdrop-blur">
                                {{ $step }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
