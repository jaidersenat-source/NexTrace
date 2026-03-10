<header class="h-16 bg-white border-b border-border shadow-sm flex items-center px-4 sm:px-6 lg:px-8 shrink-0 z-20">
    <div class="flex items-center justify-between w-full gap-4">

        {{-- ── Left: Hamburger (mobile) + page title ── --}}
        <div class="flex items-center gap-3 min-w-0">

            {{-- Mobile sidebar toggle --}}
            <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden flex items-center justify-center w-9 h-9 rounded-lg border border-border text-ink-muted hover:text-ink hover:bg-surface transition-colors shrink-0"
                    aria-label="Abrir menú">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>

            {{-- Breadcrumb / company name --}}
            @auth
            @php $empresa = auth()->user()->empresa; @endphp
            <div class="hidden sm:flex items-center gap-2 min-w-0">
                @if($empresa)
                <span class="text-xs font-semibold text-ink-faint uppercase tracking-wider truncate">
                    {{ $empresa->nombre }}
                </span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="2" stroke-linecap="round" class="shrink-0">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
                @endif
                <span class="text-sm font-semibold text-ink truncate">
                    {{ request()->routeIs('dashboard') ? 'Dashboard' : (request()->routeIs('activos.*') ? 'Activos' : (request()->routeIs('reportes.*') ? 'Reportes' : (request()->routeIs('activity-logs.*') ? 'Auditoría' : (request()->routeIs('empresa.*') ? 'Configuración' : (request()->routeIs('mantenimientos.*') ? 'Mantenimientos' : 'Panel'))))) }}
                </span>
            </div>
            @endauth
        </div>

        {{-- ── Right: Notifications + User dropdown ── --}}
        <div class="flex items-center gap-2 shrink-0">

            {{-- Notifications --}}
            @auth
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open; fetchNotificaciones(); fetchNotificacionesLista()"
                        class="relative flex items-center justify-center w-9 h-9 rounded-lg text-ink-muted hover:text-ink hover:bg-surface border border-transparent hover:border-border transition-all">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <span id="notif-badge"
                          class="absolute -top-0.5 -right-0.5 min-w-[16px] h-4 px-0.5 bg-red-500 text-white text-[10px] font-bold rounded-full items-center justify-center hidden"
                          style="display:none; line-height:16px; text-align:center;">
                    </span>
                </button>

                <div x-show="open"
                     @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-[0_8px_32px_rgba(13,17,23,0.12)] border border-border z-50"
                     style="display:none;">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-border">
                        <p class="font-display font-bold text-sm text-ink">Notificaciones</p>
                        <a href="{{ route('notificaciones.index') }}" class="text-xs font-medium text-brand hover:text-brand-light transition-colors">
                            Ver todas
                        </a>
                    </div>
                    <div id="notif-lista" class="max-h-72 overflow-y-auto divide-y divide-border">
                        <p class="px-4 py-6 text-center text-xs text-ink-faint">Cargando...</p>
                    </div>
                </div>
            </div>
            @endauth

            {{-- User dropdown --}}
            @auth
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-xl border border-border hover:border-brand/30 hover:bg-surface transition-all duration-150">
                    <div class="w-7 h-7 rounded-full bg-brand flex items-center justify-center text-white font-display font-bold text-xs shrink-0">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <span class="hidden sm:block text-sm font-medium text-ink max-w-[120px] truncate">
                        {{ Auth::user()->name }}
                    </span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2.5" stroke-linecap="round"
                         :class="open ? 'rotate-180' : ''"
                         class="transition-transform duration-150 shrink-0">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </button>

                <div x-show="open"
                     @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-[0_8px_32px_rgba(13,17,23,0.12)] border border-border z-50 overflow-hidden"
                     style="display:none;">

                    {{-- User info header --}}
                    <div class="px-4 py-3 border-b border-border">
                        <p class="text-sm font-semibold text-ink truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-ink-faint truncate mt-0.5">{{ Auth::user()->email }}</p>
                    </div>

                    <div class="py-1.5">
                        {{-- Profile --}}
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-ink-muted hover:text-ink hover:bg-surface transition-colors">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                            Mi perfil
                        </a>

                        @if(auth()->user() && auth()->user()->esAdmin())
                        <a href="{{ route('usuarios.index') }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-ink-muted hover:text-ink hover:bg-surface transition-colors">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                            Usuarios
                        </a>
                        <a href="{{ route('empresa.edit') }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-ink-muted hover:text-ink hover:bg-surface transition-colors">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                                <circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                            </svg>
                            Configuración
                        </a>
                        @endif

                        @if(auth()->user() && auth()->user()->esSuperAdmin())
                        <div class="my-1 mx-4 h-px bg-border"></div>
                        <a href="{{ route('super-admin.dashboard') }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-brand hover:bg-brand/5 transition-colors font-medium">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                                <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            Panel Super Admin
                        </a>
                        @endif
                    </div>

                    {{-- Logout --}}
                    <div class="border-t border-border py-1.5">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:text-red-600 hover:bg-red-50 transition-colors">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                    <polyline points="16 17 21 12 16 7"/>
                                    <line x1="21" y1="12" x2="9" y2="12"/>
                                </svg>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </div>
</header>

<script>
function fetchNotificaciones() {
    fetch('/notificaciones/conteo')
        .then(r => r.json())
        .then(data => actualizarBadge(data.count))
        .catch(() => {});
}

function actualizarBadge(count) {
    const badge = document.getElementById('notif-badge');
    if (!badge) return;
    if (count > 0) {
        badge.textContent = count > 9 ? '9+' : count;
        badge.style.display = 'flex';
    } else {
        badge.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    fetch('{{ route('notificaciones.conteo') }}')
        .then(r => r.json())
        .then(data => actualizarBadge(data.count))
        .catch(() => {});
});

function fetchNotificacionesLista() {
    const lista = document.getElementById('notif-lista');
    if (!lista) return;
    lista.innerHTML = '<p class="px-4 py-6 text-center text-xs text-ink-faint">Cargando...</p>';

    fetch('{{ route('notificaciones.lista') }}')
        .then(r => r.json())
        .then(data => {
            actualizarBadge(data.count || 0);

            const items = data.data || [];
            if (items.length === 0) {
                lista.innerHTML = '<p class="px-4 py-6 text-center text-xs text-ink-faint">No hay notificaciones</p>';
                return;
            }

            lista.innerHTML = '';
            items.forEach(n => {
                const a = document.createElement('a');
                a.href = n.abrir_url || '#';
                a.className = 'flex items-start gap-3 px-4 py-3 hover:bg-surface transition-colors';

                const iconWrap = document.createElement('div');
                iconWrap.className = 'w-9 h-9 rounded-md bg-surface flex items-center justify-center text-sm';
                iconWrap.textContent = n.icono || '';

                const body = document.createElement('div');
                body.className = 'flex-1';

                const title = document.createElement('p');
                title.className = 'text-sm font-medium text-ink';
                title.textContent = n.titulo || '';

                const msg = document.createElement('p');
                msg.className = 'text-xs text-ink-faint mt-0.5 truncate';
                msg.textContent = n.mensaje || '';

                const time = document.createElement('time');
                time.className = 'text-xs text-ink-faint ml-2';
                time.textContent = n.created_at || '';

                body.appendChild(title);
                body.appendChild(msg);
                a.appendChild(iconWrap);
                a.appendChild(body);
                a.appendChild(time);

                lista.appendChild(a);
            });
        })
        .catch(() => {
            lista.innerHTML = '<p class="px-4 py-6 text-center text-xs text-ink-faint">Error cargando notificaciones</p>';
        });
}
</script>