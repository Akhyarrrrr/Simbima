<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SIMBIMA</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-paper font-sans antialiased">
        <main class="flex min-h-screen items-center justify-center px-6 py-12">
            <section class="mx-auto max-w-2xl text-center">
                <h1 class="font-display text-5xl font-semibold tracking-tight text-navy">
                    SIMBIMA
                </h1>

                <div class="mx-auto mt-6 h-px w-24 bg-gold" aria-hidden="true"></div>

                <p class="mt-6 text-lg leading-8 text-slate">
                    Sistem Bimbingan Mahasiswa Akhir
                </p>

                <div class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <a href="{{ route('login') }}" class="inline-flex w-full items-center justify-center rounded-md bg-navy px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2 sm:w-auto">
                        Masuk
                    </a>

                    <a href="{{ route('register') }}" class="inline-flex w-full items-center justify-center rounded-md border border-navy px-6 py-3 text-sm font-semibold text-navy transition-colors hover:bg-navy hover:text-white focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2 sm:w-auto">
                        Daftar
                    </a>
                </div>
            </section>
        </main>
    </body>
</html>
