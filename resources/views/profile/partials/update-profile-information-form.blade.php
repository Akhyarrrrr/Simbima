<section>
    <header>
        <p class="text-xs font-semibold uppercase tracking-wide text-slate">Informasi Akun</p>
        <h2 class="mt-1 font-display text-lg font-semibold text-navy">
            Data Profil
        </h2>

        <p class="mt-1 text-sm text-slate">
            Perbarui nama dan email akun SIMBIMA.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Nama" class="text-xs font-semibold uppercase tracking-wide text-slate" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-md border-slate-300 text-sm text-navy shadow-sm focus:border-navy focus:ring-navy" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" class="text-xs font-semibold uppercase tracking-wide text-slate" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-md border-slate-300 text-sm text-navy shadow-sm focus:border-navy focus:ring-navy" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-slate">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="rounded-md text-sm font-semibold text-navy underline hover:text-gold focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-forest">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate">Role</p>
            <p class="mt-1 inline-flex rounded-full border border-gold/30 bg-gold/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-gold">
                {{ $user->role }}
            </p>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex h-10 items-center rounded-md bg-navy px-4 text-sm font-semibold text-white transition-colors hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                Simpan Profil
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-forest"
                >Tersimpan.</p>
            @endif
        </div>
    </form>
</section>
