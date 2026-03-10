<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white text-sm font-bold shrink-0 shadow-sm">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight leading-none">Mi perfil</h1>
                <p class="text-sm text-ink-muted mt-0.5">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-5">
        <div>
            @include('profile.partials.update-profile-information-form')
        </div>
        <div>
            @include('profile.partials.update-password-form')
        </div>
        <div>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>