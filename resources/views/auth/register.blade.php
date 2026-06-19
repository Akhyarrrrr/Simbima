<x-guest-layout>
    <div class="mb-6">
        <p class="font-sans text-xs font-semibold uppercase tracking-[0.2em] text-slate">Simbima</p>
        <h1 class="mt-2 font-display text-xl font-semibold text-navy">Buat akun baru</h1>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-navy" />
            <x-text-input id="name" class="mt-1 block h-10 w-full border-slate-300 focus:border-navy focus:ring-navy" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-navy" />
            <x-text-input id="email" class="mt-1 block h-10 w-full border-slate-300 focus:border-navy focus:ring-navy" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-navy" />
            <x-text-input id="password" class="mt-1 block h-10 w-full border-slate-300 focus:border-navy focus:ring-navy" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-navy" />
            <x-text-input id="password_confirmation" class="mt-1 block h-10 w-full border-slate-300 focus:border-navy focus:ring-navy" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="space-y-4 pt-1">
            <button type="submit" class="inline-flex h-10 w-full items-center justify-center rounded-md bg-navy px-4 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                {{ __('Register') }}
            </button>

            <a class="block rounded-md text-center text-sm font-medium text-navy underline decoration-gold/60 underline-offset-4 hover:text-navy/80 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>
</x-guest-layout>
