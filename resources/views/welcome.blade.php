<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SIMBIMA</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('USK-logo.svg') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-paper font-sans antialiased">
        <main class="flex min-h-screen items-center justify-center px-6 py-12">
            <section class="mx-auto max-w-2xl text-center">
                <img src="{{ asset('USK-logo.svg') }}" alt="Logo USK" class="mx-auto mb-5 h-16 w-auto">

                <h1 class="font-display text-5xl font-semibold tracking-tight text-navy">
                    SIMBIMA
                </h1>

                <div class="mx-auto mt-6 h-px w-24 bg-gold" aria-hidden="true"></div>

                <p class="mt-6 text-lg leading-8 text-slate">
                    Sistem Bimbingan Mahasiswa Akhir
                </p>

                <div class="mt-10 flex items-center justify-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md bg-navy px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                        Masuk
                    </a>
                </div>
            </section>
        </main>
    </body>
</html>
