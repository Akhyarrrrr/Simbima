<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('USK-logo.svg') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-paper text-navy">
        <div class="min-h-screen lg:grid lg:grid-cols-2">
            <aside class="hidden bg-navy lg:flex lg:items-center lg:justify-center">
                <div class="w-full max-w-md px-12 text-center animate-simbima-fade-up">
                    <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-white p-1.5" aria-hidden="true">
                        <img src="{{ asset('USK-logo.svg') }}" alt="" class="h-14 w-auto">
                    </div>
                    <a href="/" class="text-4xl font-semibold tracking-wide text-white font-display">
                        SIMBIMA
                    </a>
                    <div class="w-32 h-px mx-auto my-6 bg-gold"></div>
                    <p class="text-sm leading-6 text-slate-300">
                        Sistem Bimbingan Mahasiswa Akhir
                    </p>
                </div>
            </aside>

            <main class="flex items-center justify-center min-h-screen px-6 py-12 bg-paper lg:min-h-0">
                <div class="w-full max-w-[400px] rounded-lg border border-slate-200 bg-white px-6 py-7 shadow-sm animate-simbima-soft-scale">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
