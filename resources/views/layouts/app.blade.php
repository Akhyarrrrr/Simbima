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
    <body class="bg-paper font-sans antialiased">
        @php
            $routeName = Route::currentRouteName() ?? 'dashboard';
            $routeLabel = \Illuminate\Support\Str::of($routeName)->replace(['.', '-'], ' ')->headline();
            $eyebrow = trim($__env->yieldContent('eyebrow')) ?: $routeLabel;
            $title = trim($__env->yieldContent('title'));
            $user = Auth::user();
        @endphp

        <div class="min-h-screen bg-paper text-navy">
            <aside class="fixed inset-y-0 left-0 z-30 flex w-[260px] flex-col bg-navy text-white shadow-xl">
                <div class="border-b border-white/10 px-7 py-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-display text-2xl font-semibold tracking-wide text-white">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white p-1" aria-hidden="true">
                            <img src="{{ asset('USK-logo.svg') }}" alt="" class="h-8 w-auto">
                        </span>
                        <span>SIMBIMA</span>
                    </a>
                    <p class="mt-2 text-xs font-medium uppercase tracking-[0.24em] text-slate-200/80">
                        Sistem Bimbingan
                    </p>
                </div>

                <nav class="flex-1 space-y-1 px-4 py-6" aria-label="Main navigation">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 focus:ring-offset-navy {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white' : 'text-slate-200' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 11.5 12 5l8 6.5V20a1 1 0 0 1-1 1h-5v-6h-4v6H5a1 1 0 0 1-1-1v-8.5Z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    @if ($user?->role === 'mahasiswa')
                        <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 focus:ring-offset-navy {{ request()->routeIs('mahasiswa.*') ? 'bg-white/10 text-white' : 'text-slate-200' }}">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8.5a5 5 0 0 1 10 0v.5M5 21v-2a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v2M9 4.5h6" />
                            </svg>
                            <span>Mahasiswa</span>
                        </a>
                    @endif

                    @if ($user?->role === 'dosen')
                        <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 focus:ring-offset-navy {{ request()->routeIs('dosen.*') ? 'bg-white/10 text-white' : 'text-slate-200' }}">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 4h10a2 2 0 0 1 2 2v14l-3-2-3 2-3-2-3 2-3-2V6a2 2 0 0 1 2-2Z" />
                                <path stroke-linecap="round" d="M8 9h8M8 13h5" />
                            </svg>
                            <span>Dosen</span>
                        </a>
                    @endif

                    @if ($user?->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 focus:ring-offset-navy {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-slate-200' }}">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <span>Admin</span>
                        </a>

                        <a href="{{ route('admin.dosen.index') }}" class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 focus:ring-offset-navy {{ request()->routeIs('admin.dosen.*') ? 'bg-white/10 text-white' : 'text-slate-200' }}">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM2.5 21a5.5 5.5 0 0 1 11 0M17 10h4M19 8v4M17 17h4" />
                            </svg>
                            <span>Dosen</span>
                        </a>

                        <a href="{{ route('admin.mahasiswa.index') }}" class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 focus:ring-offset-navy {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-white/10 text-white' : 'text-slate-200' }}">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM4 21a7 7 0 0 1 14 0M6 8h4" />
                            </svg>
                            <span>Mahasiswa</span>
                        </a>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium text-slate-200 transition-colors hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 focus:ring-offset-navy {{ request()->routeIs('profile.*') ? 'bg-white/10 text-white' : '' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM4.5 21a7.5 7.5 0 0 1 15 0" />
                        </svg>
                        <span>Profil</span>
                    </a>
                </nav>

                <div class="border-t border-white/10 px-4 py-5">
                    <div class="rounded-md bg-white/5 px-3 py-3">
                        <p class="truncate text-sm font-semibold text-white">{{ $user?->name }}</p>
                        <p class="mt-0.5 truncate text-xs text-slate-200">{{ $user?->email }}</p>
                        <p class="mt-2 inline-flex rounded border border-gold/40 px-2 py-0.5 text-[11px] font-semibold uppercase tracking-wide text-gold">
                            {{ $user?->role }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium text-slate-200 transition-colors hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 focus:ring-offset-navy">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7 20 12l-5 5M20 12H9M11 5H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h5" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </aside>

            <main class="min-h-screen bg-paper pl-[260px]">
                <div class="px-8 py-8">
                    <div class="mb-8 border-b border-gold/30 pb-5">
                        <p class="font-sans text-xs font-semibold uppercase tracking-[0.22em] text-slate">
                            {{ $eyebrow }}
                        </p>

                        @if ($title !== '')
                            <h1 class="mt-2 font-display text-2xl font-semibold text-navy">
                                {{ $title }}
                            </h1>
                        @elseif (isset($header))
                            <div class="mt-2 [&_h2]:font-display [&_h2]:text-2xl [&_h2]:font-semibold [&_h2]:leading-tight [&_h2]:text-navy [&_p]:mt-1 [&_p]:text-sm [&_p]:text-slate">
                                {{ $header }}
                            </div>
                        @else
                            <h1 class="mt-2 font-display text-2xl font-semibold text-navy">
                                {{ $routeLabel }}
                            </h1>
                        @endif
                    </div>

                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
