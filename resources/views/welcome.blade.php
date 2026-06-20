<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Simbima</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('USK-logo.svg') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-paper">
        <main class="flex items-center justify-center min-h-screen px-6 py-12">
            <section class="max-w-2xl mx-auto text-center animate-simbima-fade-up">
                <img src="{{ asset('USK-logo.svg') }}" alt="Logo USK" class="w-auto h-16 mx-auto mb-5 animate-simbima-soft-scale">

                <h1 class="text-5xl font-semibold tracking-tight font-display text-navy">
                    SIMBIMA
                </h1>

                <div class="w-24 h-px mx-auto mt-6 bg-gold" aria-hidden="true"></div>

                <p class="mt-6 text-lg leading-8 text-slate">
                    Sistem Bimbingan Mahasiswa Akhir
                </p>

                <div class="flex items-center justify-center mt-10">
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all rounded-md bg-navy hover:-translate-y-0.5 hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2 active:translate-y-0">
                        Masuk
                    </a>
                </div>
            </section>
        </main>
    </body>
</html>
