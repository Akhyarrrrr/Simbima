@section('eyebrow', 'PENGATURAN AKUN')
@section('title', 'Profil Saya')

<x-app-layout>
    <div class="space-y-6">
        <div class="max-w-3xl space-y-6">
            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
