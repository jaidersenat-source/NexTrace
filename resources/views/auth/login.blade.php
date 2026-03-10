<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión — NexTrace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-surface font-body antialiased">
<div class="min-h-screen flex flex-col lg:flex-row">

    {{-- ═══════════════════════════════════════
         LEFT PANEL — oculto en móvil
    ═══════════════════════════════════════ --}}
    <div class="hidden lg:flex lg:w-[52%] xl:w-[55%] relative flex-col justify-between overflow-hidden bg-login-panel">

        {{-- Rejilla interior --}}
        <div class="absolute inset-0 bg-login-grid bg-grid pointer-events-none"></div>

        {{-- Orb superior derecho --}}
        <div class="absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full bg-brand-light/20 blur-3xl pointer-events-none"></div>
        {{-- Orb inferior izquierdo --}}
        <div class="absolute -bottom-24 -left-16 w-80 h-80 rounded-full bg-accent/15 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col h-full px-10 xl:px-14 py-10">

            {{-- Logo --}}
             <a href="/" class="flex items-center gap-2.5 shrink-0">
            <div class="w-8 h-8 bg-brand rounded-lg flex items-center justify-center">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
            </div>
            <span class="font-display font-extrabold text-lg text-ink tracking-tight">NexTrace</span>
        </a>

            {{-- Copy central --}}
           <div class="flex-1 flex flex-col justify-center max-w-sm xl:max-w-md py-16">

    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 border border-white/15 rounded-full text-[11px] font-bold text-ink-muted tracking-[0.08em] uppercase mb-6 w-fit">
        <span class="w-1.5 h-1.5 bg-accent rounded-full animate-pulse-dot"></span>
        Plataforma multiempresa
    </div>

    <h1 class="font-display font-extrabold text-ink text-3xl xl:text-4xl leading-[1.1] tracking-tight mb-5">
        Bienvenido al control inteligente de activos
    </h1>

    <p class="text-ink-muted text-base leading-relaxed mb-10">
        Gestiona, audita y rastrea cada activo de tu empresa con trazabilidad completa y acceso por roles.
    </p>

                {{-- Beneficios --}}
                <div class="flex flex-col gap-5">
        @foreach([
            [
                'icon'  => '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3M17 14v3h3"/>',
                'title' => 'Control total por QR',
                'desc'  => 'Escanea y registra el uso de cada activo en segundos.',
            ],
            [
                'icon'  => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
                'title' => 'Roles y multiempresa',
                'desc'  => 'Cada empresa con su propio espacio aislado y permisos.',
            ],
            [
                'icon'  => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
                'title' => 'Auditoría en tiempo real',
                'desc'  => 'Historial completo de movimientos con quién y cuándo.',
            ],
        ] as $b)
       <div class="flex items-start gap-4">
    <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/15 flex items-center justify-center shrink-0">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
            {!! $b['icon'] !!}
        </svg>
    </div>
    <div>
        <p class="font-display font-semibold text-ink text-sm">{{ $b['title'] }}</p>
        <p class="text-ink-faint text-sm leading-snug mt-0.5">{{ $b['desc'] }}</p>
    </div>
</div>
        @endforeach
    </div>
</div>

            {{-- Social proof --}}
            <div class="relative z-10 flex items-center gap-4 py-6 border-t border-white/10">
    <div class="flex -space-x-2">
        @foreach(['#0F4CDB','#7C3AED','#00D4AA'] as $c)
        <div class="w-8 h-8 rounded-full border-2 border-brand-dark flex items-center justify-center" style="background:{{ $c }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
        @endforeach
    </div>
    <p class="text-ink-faint text-xs leading-snug">
        Más de <span class="text-ink font-semibold">500 empresas</span> confían en NexTrace
    </p>
</div>

        </div>
    </div>


    {{-- ═══════════════════════════════════════
         RIGHT PANEL — formulario
    ═══════════════════════════════════════ --}}
    <div class="flex-1 flex flex-col items-center justify-center px-4 sm:px-8 py-12 bg-white lg:bg-surface">

        {{-- Logo móvil --}}
        <div class="lg:hidden mb-8 flex flex-col items-center gap-3">
            <div class="w-11 h-11 bg-brand rounded-xl flex items-center justify-center shadow-[0_4px_16px_rgba(15,76,219,0.30)]">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
            </div>
            <span class="font-display font-extrabold text-ink text-xl tracking-tight">NexTrace</span>
        </div>

        {{-- Card --}}
        <div class="w-full max-w-md bg-white rounded-2xl border border-border shadow-[0_8px_40px_rgba(13,17,23,0.08)] px-8 py-10 sm:px-10">

            {{-- Encabezado --}}
            <div class="mb-8 animate-fade-up-1">
                <h2 class="font-display font-extrabold text-ink text-2xl sm:text-3xl tracking-tight mb-1.5">
                    Iniciar sesión
                </h2>
                <p class="text-ink-muted text-sm">
                    Ingresa tus credenciales para acceder al panel
                </p>
            </div>

            {{-- Estado de sesión --}}
            @if (session('status'))
            <div class="mb-6 flex items-center gap-3 bg-accent/10 border border-accent/25 text-accent rounded-xl px-4 py-3 text-sm font-medium animate-fade-up-1">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
                </svg>
                {{ session('status') }}
            </div>
            @endif

            {{-- Formulario --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div class="animate-fade-up-2">
                    <label for="email" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                        Correo electrónico
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="tu@empresa.com"
                            class="w-full pl-10 pr-4 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint
                                   outline-none transition-all duration-200
                                   focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white
                                   @error('email') border-red-400 bg-red-50 @enderror"
                        >
                    </div>
                    @error('email')
                    <p class="mt-2 text-xs text-red-500 flex items-center gap-1.5">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="animate-fade-up-3">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-semibold text-ink font-display">
                            Contraseña
                        </label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-xs font-medium text-brand hover:text-brand-light transition-colors">
                            ¿Olvidaste tu contraseña?
                        </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full pl-10 pr-11 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint
                                   outline-none transition-all duration-200
                                   focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white
                                   @error('password') border-red-400 bg-red-50 @enderror"
                        >
                        <button type="button" id="toggle-password"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-ink-faint hover:text-ink-muted transition-colors">
                            <svg id="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eye-off-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <p class="mt-2 text-xs text-red-500 flex items-center gap-1.5">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Recordarme --}}
                <div class="flex items-center gap-3 animate-fade-up-4">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="w-4 h-4 rounded border-border text-brand bg-surface cursor-pointer
                               focus:ring-2 focus:ring-brand/20 focus:ring-offset-0 transition-colors"
                    >
                    <label for="remember_me" class="text-sm text-ink-muted cursor-pointer select-none hover:text-ink transition-colors">
                        Recordarme en este dispositivo
                    </label>
                </div>

                {{-- Botón submit --}}
                <div class="pt-1 animate-fade-up-4">
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-3.5 px-6
                                   bg-brand text-white font-display font-semibold text-base rounded-xl
                                   hover:bg-brand-light transition-all duration-200
                                   hover:-translate-y-0.5 active:translate-y-0
                                   shadow-[0_4px_16px_rgba(15,76,219,0.30)] hover:shadow-[0_8px_24px_rgba(15,76,219,0.35)]
                                   focus:outline-none focus:ring-2 focus:ring-brand/30 focus:ring-offset-2">
                        Iniciar sesión
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <polyline points="10 17 15 12 10 7"/>
                            <line x1="15" y1="12" x2="3" y2="12"/>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Divisor --}}
            <div class="flex items-center gap-3 my-6 animate-fade-up-5">
                <div class="flex-1 h-px bg-border"></div>
                <span class="text-xs text-ink-faint font-medium">¿Eres nuevo aquí?</span>
                <div class="flex-1 h-px bg-border"></div>
            </div>

            {{-- Registro --}}
            @if (Route::has('register'))
            <div class="animate-fade-up-5">
                <a href="{{ route('register') }}"
                   class="w-full flex items-center justify-center gap-2 py-3 px-6
                          bg-transparent border border-border text-ink font-display font-semibold text-sm rounded-xl
                          hover:border-brand hover:text-brand hover:bg-brand/4
                          transition-all duration-200 hover:-translate-y-0.5">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="19" y1="8" x2="19" y2="14"/>
                        <line x1="22" y1="11" x2="16" y2="11"/>
                    </svg>
                    Crear una cuenta nueva
                </a>
            </div>
            @endif
        </div>

        {{-- Pie --}}
        <p class="mt-6 text-xs text-ink-faint text-center animate-fade-up-5">
            © {{ date('Y') }} NexTrace · Todos los derechos reservados
        </p>
    </div>

</div>

<script>
    const toggleBtn  = document.getElementById('toggle-password');
    const pwInput    = document.getElementById('password');
    const eyeIcon    = document.getElementById('eye-icon');
    const eyeOffIcon = document.getElementById('eye-off-icon');

    toggleBtn.addEventListener('click', () => {
        const show   = pwInput.type === 'password';
        pwInput.type = show ? 'text' : 'password';
        eyeIcon.classList.toggle('hidden',     show);
        eyeOffIcon.classList.toggle('hidden', !show);
    });
</script>

</body>
</html>