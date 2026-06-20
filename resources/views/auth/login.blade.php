<x-guest-layout>
    <div class="mb-6 animate-simbima-fade-up">
        <p class="font-sans text-xs font-semibold uppercase tracking-[0.2em] text-slate">Simbima</p>
        <h1 class="mt-2 font-display text-xl font-semibold text-navy">Masuk ke akun</h1>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5 animate-simbima-fade-up" style="animation-delay: 80ms">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-navy" />
            <x-text-input id="email" class="mt-1 block h-10 w-full border-slate-300 focus:border-navy focus:ring-navy" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div x-data="{ showPassword: false }">
            <x-input-label for="password" :value="__('Password')" class="text-navy" />
            <div class="relative mt-1">
                <x-text-input id="password" class="block h-10 w-full border-slate-300 pr-11 focus:border-navy focus:ring-navy" x-bind:type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" />
                <button type="button" x-on:click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex w-10 items-center justify-center rounded-r-md text-slate transition-colors hover:text-navy focus:outline-none focus:ring-2 focus:ring-inset focus:ring-navy" x-bind:aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'">
                    <svg x-show="!showPassword" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>
                    <svg x-show="showPassword" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18M10.6 10.6A3 3 0 0 0 13.4 13.4M7.1 7.6C4.2 9.2 2.5 12 2.5 12s3.5 6 9.5 6c1.7 0 3.2-.5 4.4-1.2M19.2 15.2c1.5-1.4 2.3-3.2 2.3-3.2S18 6 12 6c-.8 0-1.6.1-2.3.3" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-navy shadow-sm focus:ring-navy" name="remember">
                <span class="ms-2 text-sm text-slate">{{ __('Remember me') }}</span>
            </label>
        </div>

        <button type="submit" class="inline-flex h-10 w-full items-center justify-center rounded-md bg-navy px-4 text-sm font-semibold text-white transition-all hover:-translate-y-0.5 hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2 active:translate-y-0">
            {{ __('Log in') }}
        </button>
    </form>
</x-guest-layout>
