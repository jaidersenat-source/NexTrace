<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md shrink-0" style="background: linear-gradient(135deg, #0F4CDB, #3B6FF0)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round">
                    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <path d="M14 14h3v3"/><path d="M20 14v3h-3"/><path d="M14 20h3"/><path d="M20 20h.01"/>
                </svg>
            </div>
            <div>
                <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight leading-none">Escáner QR</h1>
                <p class="text-sm text-ink-muted mt-0.5">Escanea el código QR de un activo para registrar uso</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-lg mx-auto space-y-5" x-data="scannerApp()">

        @include('partials.alert')

        {{-- Escáner --}}
        <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                <div class="w-7 h-7 rounded-lg bg-brand/10 border border-brand/15 flex items-center justify-center shrink-0">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2.5" stroke-linecap="round">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                        <circle cx="12" cy="13" r="4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-display font-bold text-sm text-ink">Cámara</h2>
                    <p class="text-xs text-ink-muted mt-0.5">Apunta al código QR del equipo</p>
                </div>
            </div>

            <div class="p-5">
                {{-- Estado: Esperando --}}
                <div x-show="estado === 'esperando'" class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-brand/8 border-2 border-dashed border-brand/20 flex items-center justify-center">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="1.5" stroke-linecap="round">
                            <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                            <path d="M14 14h3v3"/><path d="M20 14v3h-3"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-ink mb-1">Listo para escanear</p>
                    <p class="text-xs text-ink-faint mb-5">Presiona el botón para activar la cámara</p>
                    <button @click="iniciarEscaner()"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-brand text-white font-display font-semibold text-sm rounded-xl
                                   hover:bg-brand-light transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(15,76,219,0.25)]">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                            <circle cx="12" cy="13" r="4"/>
                        </svg>
                        Activar cámara
                    </button>
                </div>

                {{-- Estado: Escaneando --}}
                <div x-show="estado === 'escaneando'" x-cloak>
                    <div id="qr-reader" class="rounded-xl overflow-hidden border border-border"></div>
                    <button @click="detenerEscaner()"
                            class="mt-4 w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-border text-ink-muted font-display font-semibold text-sm rounded-xl
                                   hover:border-red-300 hover:text-red-500 hover:bg-red-50 transition-all">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                        </svg>
                        Detener cámara
                    </button>
                </div>

                {{-- Estado: Error --}}
                <div x-show="estado === 'error'" x-cloak class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="1.5" stroke-linecap="round">
                            <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-red-600 mb-1" x-text="errorMsg"></p>
                    <p class="text-xs text-ink-faint mb-5">Verifica los permisos de cámara e intenta de nuevo</p>
                    <button @click="estado = 'esperando'"
                            class="inline-flex items-center gap-2 px-5 py-2.5 border border-border text-ink font-display font-semibold text-sm rounded-xl
                                   hover:border-brand hover:text-brand transition-all">
                        Reintentar
                    </button>
                </div>
            </div>
        </div>

        {{-- Instrucciones --}}
        <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
            <div class="p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">¿Cómo funciona?</h3>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand/10 text-brand flex items-center justify-center shrink-0 text-xs font-bold">1</span>
                        <div>
                            <p class="text-sm font-semibold text-ink">Escanea el QR</p>
                            <p class="text-xs text-ink-faint mt-0.5">Apunta la cámara al código QR pegado en el equipo</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand/10 text-brand flex items-center justify-center shrink-0 text-xs font-bold">2</span>
                        <div>
                            <p class="text-sm font-semibold text-ink">Toma el equipo</p>
                            <p class="text-xs text-ink-faint mt-0.5">El sistema registrará que estás usando el activo y empezará un contador</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand/10 text-brand flex items-center justify-center shrink-0 text-xs font-bold">3</span>
                        <div>
                            <p class="text-sm font-semibold text-ink">Devuelve el equipo</p>
                            <p class="text-xs text-ink-faint mt-0.5">Escanea de nuevo para liberar. Puedes agregar observaciones opcionales</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- html5-qrcode CDN --}}
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <script>
    function scannerApp() {
        return {
            estado: 'esperando',
            errorMsg: '',
            scanner: null,

            iniciarEscaner() {
                this.estado = 'escaneando';

                this.$nextTick(() => {
                    this.scanner = new Html5Qrcode('qr-reader');

                    this.scanner.start(
                        { facingMode: 'environment' },
                        { fps: 10, qrbox: { width: 250, height: 250 } },
                        (decodedText) => this.onScanSuccess(decodedText),
                        () => {} // error silencioso en cada frame
                    ).catch(err => {
                        this.errorMsg = 'No se pudo acceder a la cámara.';
                        this.estado = 'error';
                    });
                });
            },

            detenerEscaner() {
                if (this.scanner) {
                    this.scanner.stop().then(() => {
                        this.scanner.clear();
                        this.estado = 'esperando';
                    }).catch(() => {
                        this.estado = 'esperando';
                    });
                }
            },

            onScanSuccess(url) {
                // Extraer token del URL del QR: busca /a/{token}
                const match = url.match(/\/a\/([0-9a-f\-]{36})/i);
                if (!match) {
                    this.errorMsg = 'El QR no corresponde a un activo válido.';
                    this.estado = 'error';
                    if (this.scanner) this.scanner.stop().catch(() => {});
                    return;
                }

                // Detener escáner y redirigir a la vista del activo
                if (this.scanner) {
                    this.scanner.stop().catch(() => {});
                }

                window.location.href = '/a/' + match[1];
            }
        };
    }
    </script>
</x-app-layout>
