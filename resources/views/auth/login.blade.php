<x-guest-layout>
    <div class="mb-6">
        <p class="font-sans text-xs font-semibold uppercase tracking-[0.2em] text-slate">Simbima</p>
        <h1 class="mt-2 font-display text-xl font-semibold text-navy">Masuk ke akun</h1>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-navy" />
            <x-text-input id="email" class="mt-1 block h-10 w-full border-slate-300 focus:border-navy focus:ring-navy" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-navy" />
            <x-text-input id="password" class="mt-1 block h-10 w-full border-slate-300 focus:border-navy focus:ring-navy" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-navy shadow-sm focus:ring-navy" name="remember">
                <span class="ms-2 text-sm text-slate">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="rounded-md text-sm font-medium text-navy underline decoration-gold/60 underline-offset-4 hover:text-navy/80 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="inline-flex h-10 w-full items-center justify-center rounded-md bg-navy px-4 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
            {{ __('Log in') }}
        </button>
    </form>
</x-guest-layout>
