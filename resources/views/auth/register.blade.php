<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta — NexTrace</title>
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

        {{-- Orbs decorativos --}}
        <div class="absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full bg-brand-light/20 blur-3xl pointer-events-none"></div>
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
        Sin tarjeta de crédito
    </div>

    <h1 class="font-display font-extrabold text-ink text-3xl xl:text-4xl leading-[1.1] tracking-tight mb-5">
        Crea tu organización y comienza a gestionar tus activos
    </h1>

    <p class="text-ink-muted text-base leading-relaxed mb-10">
        Configura tu empresa en minutos. Un solo registro crea tu espacio, tu cuenta de administrador y todo lo necesario para empezar.
    </p>

                {{-- Beneficios --}}
                <div class="flex flex-col gap-5">
    @foreach([
        [
            'icon'  => '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3M17 14v3h3"/>',
            'title' => 'Control por QR',
            'desc'  => 'Genera códigos QR únicos y registra el uso de cada activo al instante.',
        ],
        [
            'icon'  => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
            'title' => 'Multiempresa',
            'desc'  => 'Cada organización tiene su espacio aislado con roles y permisos propios.',
        ],
        [
            'icon'  => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
            'title' => 'Reportes en tiempo real',
            'desc'  => 'Dashboard con métricas, historial y auditoría de cada movimiento.',
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
            {{-- Social proof --}}
<div class="relative z-10 flex items-center gap-4 py-6 border-t border-white/10">
    <div class="flex -space-x-2">
        @foreach(['#0F4CDB','#7C3AED','#00D4AA'] as $c)
        <div class="w-8 h-8 rounded-full border-2 border-brand-dark flex items-center justify-center" style="background:{{ $c }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#0D1117" stroke-width="2.5">
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
            <div class="mb-7 animate-fade-up-1">
                <h2 class="font-display font-extrabold text-ink text-2xl sm:text-3xl tracking-tight mb-1.5">
                    Crear cuenta
                </h2>
                <p class="text-ink-muted text-sm">
                    Configura tu empresa y empieza en minutos
                </p>
            </div>

            {{-- Formulario --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- ── Sección empresa ── --}}
                <div class="animate-fade-up-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-5 h-5 rounded-md bg-brand/10 border border-brand/20 flex items-center justify-center shrink-0">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-brand tracking-wider uppercase font-display">Información de la empresa</span>
                    </div>

                    {{-- Nombre empresa --}}
                    <div>
                        <label for="empresa_nombre" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                            Nombre de la empresa
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                    <polyline points="9 22 9 12 15 12 15 22"/>
                                </svg>
                            </div>
                            <input
                                id="empresa_nombre"
                                type="text"
                                name="empresa_nombre"
                                value="{{ old('empresa_nombre') }}"
                                required
                                autofocus
                                placeholder="Mi Empresa S.A."
                                class="w-full pl-10 pr-4 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint
                                       outline-none transition-all duration-200
                                       focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white
                                       @error('empresa_nombre') border-red-400 bg-red-50 @enderror"
                            >
                        </div>
                        @error('empresa_nombre')
                        <p class="mt-2 text-xs text-red-500 flex items-center gap-1.5">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                {{-- Separador --}}
                <div class="flex items-center gap-3 animate-fade-up-2">
                    <div class="flex-1 h-px bg-border"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-md bg-accent/10 border border-accent/20 flex items-center justify-center shrink-0">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#00D4AA" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-accent tracking-wider uppercase font-display whitespace-nowrap">Datos del administrador</span>
                    </div>
                    <div class="flex-1 h-px bg-border"></div>
                </div>

                {{-- ── Nombre + Apellido (2 columnas) ── --}}
                <div class="grid grid-cols-2 gap-3 animate-fade-up-3">
                    <div>
                        <label for="nombre" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                            Nombre
                        </label>
                        <input
                            id="nombre"
                            type="text"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            required
                            placeholder="Juan"
                            class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint
                                   outline-none transition-all duration-200
                                   focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white
                                   @error('nombre') border-red-400 bg-red-50 @enderror"
                        >
                        @error('nombre')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                            Apellido
                        </label>
                        <input
                            id="apellido"
                            type="text"
                            name="apellido"
                            value="{{ old('apellido') }}"
                            placeholder="Pérez"
                            class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint
                                   outline-none transition-all duration-200
                                   focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white
                                   @error('apellido') border-red-400 bg-red-50 @enderror"
                        >
                        @error('apellido')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="animate-fade-up-3">
                    <label for="email" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                        Correo electrónico
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                            autocomplete="email"
                            placeholder="juan@miempresa.com"
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
                <div class="animate-fade-up-4">
                    <label for="password" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                        Contraseña
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Mínimo 8 caracteres"
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

                {{-- Confirmar password --}}
                <div class="animate-fade-up-4">
                    <label for="password_confirmation" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                        Confirmar contraseña
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 11l3 3L22 4"/>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                            </svg>
                        </div>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Repite la contraseña"
                            class="w-full pl-10 pr-4 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint
                                   outline-none transition-all duration-200
                                   focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white
                                   @error('password_confirmation') border-red-400 bg-red-50 @enderror"
                        >
                    </div>
                    @error('password_confirmation')
                    <p class="mt-2 text-xs text-red-500 flex items-center gap-1.5">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Términos implícitos --}}
                <p class="text-xs text-ink-faint leading-relaxed animate-fade-up-5">
                    Al crear tu cuenta aceptas nuestros
                    <span class="text-brand font-medium cursor-pointer hover:underline">Términos de servicio</span>
                    y nuestra
                    <span class="text-brand font-medium cursor-pointer hover:underline">Política de privacidad</span>.
                </p>

                {{-- Botón submit --}}
                <div class="pt-1 animate-fade-up-5">
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-3.5 px-6
                                   bg-brand text-white font-display font-semibold text-base rounded-xl
                                   hover:bg-brand-light transition-all duration-200
                                   hover:-translate-y-0.5 active:translate-y-0
                                   shadow-[0_4px_16px_rgba(15,76,219,0.30)] hover:shadow-[0_8px_24px_rgba(15,76,219,0.35)]
                                   focus:outline-none focus:ring-2 focus:ring-brand/30 focus:ring-offset-2">
                        Crear cuenta y empresa
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <line x1="19" y1="8" x2="19" y2="14"/>
                            <line x1="22" y1="11" x2="16" y2="11"/>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Divisor --}}
            <div class="flex items-center gap-3 my-6 animate-fade-up-5">
                <div class="flex-1 h-px bg-border"></div>
                <span class="text-xs text-ink-faint font-medium">¿Ya tienes cuenta?</span>
                <div class="flex-1 h-px bg-border"></div>
            </div>

            {{-- Link login --}}
            <div class="animate-fade-up-5">
                <a href="{{ route('login') }}"
                   class="w-full flex items-center justify-center gap-2 py-3 px-6
                          bg-transparent border border-border text-ink font-display font-semibold text-sm rounded-xl
                          hover:border-brand hover:text-brand hover:bg-brand/4
                          transition-all duration-200 hover:-translate-y-0.5">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    Iniciar sesión
                </a>
            </div>
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