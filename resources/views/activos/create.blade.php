<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('activos.index') }}"
               class="flex items-center justify-center w-9 h-9 rounded-xl border border-border text-ink-muted hover:text-ink hover:border-brand/40 hover:bg-brand/5 transition-all shrink-0">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            </a>
            <div>
                <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight">Nuevo activo</h1>
                <p class="text-sm text-ink-muted mt-0.5">Completa los datos para registrar un nuevo activo</p>
            </div>
        </div>
    </x-slot>
    @vite('resources/css/create-activo.css')

    {{-- ════════════════════════════════ --}}
    {{--  Página                         --}}
    {{-- ════════════════════════════════ --}}
    <div class="create-grid">

        {{-- ── Stepper ── --}}
        <aside class="create-stepper">
            <div class="stepper-card">
                <p class="stepper-head">Secciones</p>

                <div class="step is-active" id="stp-1" onclick="scrollToId('sec-general')">
                    <div class="step-num">1</div>
                    <span class="step-name">General</span>
                </div>
                <div class="step-line"></div>

                <div class="step" id="stp-2" onclick="scrollToId('sec-adicional')">
                    <div class="step-num">2</div>
                    <span class="step-name">Adicional</span>
                </div>
                <div class="step-line"></div>

                <div class="step" id="stp-3" onclick="scrollToId('sec-dinamica')" style="opacity:.35;pointer-events:none;">
                    <div class="step-num">3</div>
                    <span class="step-name">Atributos</span>
                </div>
            </div>
        </aside>

        {{-- ── Form ── --}}
        <form action="{{ route('activos.store') }}" method="POST" class="form-col" style="display:grid;gap:14px;">
            @csrf

            {{-- ── Sección 1: General ── --}}
            <div class="sec-card" id="sec-general">
                <div class="sec-head">
                    <div class="sec-icon" style="background:rgba(15,76,219,.08);border:1px solid rgba(15,76,219,.15);">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2.5" stroke-linecap="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                    </div>
                    <h2 class="sec-title">Información general</h2>
                    <span class="sec-badge">01 / 03</span>
                </div>

                <div class="sec-body">
                    {{-- Categoría --}}
                    <div>
                        <div class="cat-header">
                            <label class="nt-label" for="categoria_id" style="margin-bottom:0;">
                                Categoría <span class="req">*</span>
                            </label>
                            <button type="button" id="btn-crear-categoria" class="btn-new-cat">
                                <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Nueva categoría
                            </button>
                        </div>
                        <select id="categoria_id" name="categoria_id" required class="nt-select" style="margin-top:7px;">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}"
                                        data-campos="{{ json_encode($cat->campos) }}"
                                        {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->icono }} {{ $cat->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <p class="field-error">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    @include('activos.partials.form')
                </div>
            </div>

            {{-- ── Sección 2: Adicional ── --}}
            <div class="sec-card" id="sec-adicional">
                <div class="sec-head">
                    <div class="sec-icon" style="background:rgba(0,212,170,.08);border:1px solid rgba(0,212,170,.2);">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#00D4AA" stroke-width="2.5" stroke-linecap="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <h2 class="sec-title">Información adicional</h2>
                    <span class="sec-badge">02 / 03</span>
                </div>

                <div class="sec-body">
                    <div class="grid-2">
                        <div>
                            <label class="nt-label" for="numero_serie">
                                Número de serie <span class="opt">(opcional)</span>
                            </label>
                            <input id="numero_serie" type="text" name="numero_serie"
                                   value="{{ old('numero_serie') }}" placeholder="SN-XXXXXXXX"
                                   class="nt-input is-mono">
                        </div>
                        <div>
                            <label class="nt-label" for="fecha_adquisicion">Fecha de adquisición</label>
                            <input id="fecha_adquisicion" type="date" name="fecha_adquisicion"
                                   value="{{ old('fecha_adquisicion') }}" class="nt-input">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Sección 3: Atributos dinámicos ── --}}
            <div class="sec-card" id="sec-dinamica" style="display:none;">
                <div class="sec-head">
                    <div class="sec-icon" style="background:rgba(124,58,237,.08);border:1px solid rgba(124,58,237,.18);">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#7C3AED" stroke-width="2.5" stroke-linecap="round">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>
                        </svg>
                    </div>
                    <h2 class="sec-title" id="titulo-dinamico">Atributos del activo</h2>
                    <span class="sec-badge">03 / 03</span>
                </div>
                <div id="campos-dinamicos" class="sec-body"></div>
            </div>

            {{-- ── Actions ── --}}
            <div class="action-bar">
                <a href="{{ route('activos.index') }}" class="btn-ghost">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Guardar activo
                </button>
            </div>
        </form>
    </div>

    {{-- ════════════════════════════════ --}}
    {{--  Modal — Nueva categoría        --}}
    {{-- ════════════════════════════════ --}}
    <div id="modal-crear-categoria" class="nt-overlay" style="display:none;">
        <div class="nt-modal">
            <div class="modal-head">
                <h3 class="modal-title">Nueva categoría</h3>
                <button type="button" class="modal-close js-close-modal" aria-label="Cerrar">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div class="modal-body">
                {{-- Nombre --}}
                <div>
                    <label class="nt-label" for="cat-nombre">Nombre <span class="req">*</span></label>
                    <input id="cat-nombre" type="text" placeholder="Ej. Laptops, Herramientas…" class="nt-input">
                </div>

                {{-- Ícono + Global --}}
                <div class="grid-2">
                    <div>
                        <label class="nt-label" for="cat-icono">Ícono <span class="opt">(emoji)</span></label>
                        <input id="cat-icono" type="text" placeholder="📦" class="nt-input" style="font-size:22px;text-align:center;max-width:80px;">
                    </div>
                    @if(auth()->user()?->esSuperAdmin())
                    <div style="display:flex;align-items:flex-end;padding-bottom:3px;">
                        <label class="nt-toggle">
                            <input id="cat-global" type="checkbox">
                            <div class="toggle-track"><div class="toggle-thumb"></div></div>
                            <span class="toggle-label">Global para todas las empresas</span>
                        </label>
                    </div>
                    @endif
                </div>

                {{-- Atributos --}}
                <div>
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                        <p class="nt-label" style="margin-bottom:0;">
                            Atributos <span class="opt">(define los campos del formulario)</span>
                        </p>
                    </div>
                    <div id="campos-list" style="display:grid;gap:8px;"></div>
                    <button type="button" id="add-campo" class="btn-add-campo">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Añadir atributo
                    </button>
                </div>
            </div>

            <div class="modal-foot">
                <button type="button" class="btn-ghost js-close-modal" style="padding:9px 18px;font-size:13px;">Cancelar</button>
                <button type="button" id="guardar-categoria" class="btn-primary" style="padding:9px 22px;font-size:13px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Guardar categoría
                </button>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════ --}}
    {{--  Scripts                        --}}
    {{-- ════════════════════════════════ --}}
    <script>
    (() => {
        /* ── Refs ── */
        const categoriaSelect = document.getElementById('categoria_id');
        const secDinamica     = document.getElementById('sec-dinamica');
        const tituloDinamico  = document.getElementById('titulo-dinamico');
        const camposDin       = document.getElementById('campos-dinamicos');
        const modal           = document.getElementById('modal-crear-categoria');
        const camposList      = document.getElementById('campos-list');
        const oldAtributos    = @json(old('atributos', []));

        /* ── Scroll helper ── */
        window.scrollToId = id => document.getElementById(id)?.scrollIntoView({ behavior:'smooth', block:'start' });

        /* ── Stepper highlight via IntersectionObserver ── */
        const sections = [
            { el: document.getElementById('sec-general'),   stp: document.getElementById('stp-1') },
            { el: document.getElementById('sec-adicional'), stp: document.getElementById('stp-2') },
            { el: secDinamica,                               stp: document.getElementById('stp-3') },
        ];

        new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (!e.isIntersecting) return;
                const found = sections.find(s => s.el === e.target);
                if (found) {
                    sections.forEach(s => s.stp.classList.remove('is-active'));
                    found.stp.classList.add('is-active');
                }
            });
        }, { threshold: 0.45 }).observe && sections.forEach(s => {
            if (s.el) new IntersectionObserver(entries => {
                if (entries[0].isIntersecting) {
                    sections.forEach(x => x.stp.classList.remove('is-active'));
                    s.stp.classList.add('is-active');
                }
            }, { threshold: 0.45 }).observe(s.el);
        });

        /* ── Modal open / close ── */
        const openModal  = () => { modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; };
        const closeModal = () => { modal.style.display = 'none';  document.body.style.overflow = ''; };

        document.getElementById('btn-crear-categoria').addEventListener('click', openModal);
        document.querySelectorAll('.js-close-modal').forEach(b => b.addEventListener('click', closeModal));
        modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });

        /* ── Crear fila de campo ── */
        function createCampoRow() {
            const div = document.createElement('div');
            div.className = 'campo-row';
            div.innerHTML = `
                <button type="button" class="campo-remove" title="Eliminar">✕</button>
                <div class="campo-grid">
                    <div>
                        <label class="nt-label" style="font-size:11px;margin-bottom:5px;">Etiqueta</label>
                        <input type="text" placeholder="Ej. Marca" class="nt-input" style="padding:8px 10px;font-size:13px;" data-rol="label">
                    </div>
                    <div>
                        <label class="nt-label" style="font-size:11px;margin-bottom:5px;">Clave</label>
                        <input type="text" placeholder="marca" class="nt-input is-mono" style="padding:8px 10px;font-size:12px;" data-rol="clave">
                    </div>
                    <div>
                        <label class="nt-label" style="font-size:11px;margin-bottom:5px;">Tipo</label>
                        <select class="nt-select" style="padding:8px 30px 8px 10px;font-size:13px;" data-rol="tipo">
                            <option value="text">Texto</option>
                            <option value="number">Número</option>
                            <option value="select">Select</option>
                            <option value="date">Fecha</option>
                            <option value="checkbox">Checkbox</option>
                        </select>
                    </div>
                    <div class="campo-opciones" data-rol-wrap="opciones">
                        <label class="nt-label" style="font-size:11px;margin-bottom:5px;">Opciones <span class="opt">(separadas por coma)</span></label>
                        <input type="text" placeholder="Opción A, Opción B" class="nt-input" style="padding:8px 10px;font-size:13px;" data-rol="opciones">
                    </div>
                </div>
            `;

            const labelIn  = div.querySelector('[data-rol="label"]');
            const claveIn  = div.querySelector('[data-rol="clave"]');
            const tipoSel  = div.querySelector('[data-rol="tipo"]');
            const opcsWrap = div.querySelector('[data-rol-wrap="opciones"]');

            /* Auto-clave */
            labelIn.addEventListener('input', () => {
                if (!claveIn._touched)
                    claveIn.value = labelIn.value.toLowerCase()
                        .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
                        .replace(/[^a-z0-9]+/g,'_').replace(/^_|_$/g,'');
            });
            claveIn.addEventListener('input', () => { claveIn._touched = true; });

            /* Mostrar opciones solo si tipo = select */
            tipoSel.addEventListener('change', () => {
                opcsWrap.style.display = tipoSel.value === 'select' ? 'block' : 'none';
            });

            div.querySelector('.campo-remove').addEventListener('click', () => div.remove());
            camposList.appendChild(div);
        }

        document.getElementById('add-campo').addEventListener('click', createCampoRow);

        /* ── Guardar categoría ── */
        document.getElementById('guardar-categoria').addEventListener('click', async () => {
            const nombre = document.getElementById('cat-nombre').value.trim();
            const icono  = document.getElementById('cat-icono').value.trim();

            if (!nombre) {
                const inp = document.getElementById('cat-nombre');
                inp.style.borderColor = '#ef4444';
                inp.focus();
                setTimeout(() => inp.style.borderColor = '', 2000);
                return;
            }

            const campos = [];
            camposList.querySelectorAll('.campo-row').forEach(row => {
                const label   = row.querySelector('[data-rol="label"]').value.trim();
                const clave   = row.querySelector('[data-rol="clave"]').value.trim()
                    || label.toLowerCase().replace(/[^a-z0-9]+/g,'_');
                const tipo    = row.querySelector('[data-rol="tipo"]').value;
                const opciones = row.querySelector('[data-rol="opciones"]').value.trim();
                if (label) campos.push({ label, clave, tipo, opciones });
            });

            const btn = document.getElementById('guardar-categoria');
            btn.disabled = true;
            btn.style.opacity = '.65';

            try {
                const res = await fetch('{{ route('categorias.store') }}', {
                    method:  'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept':       'application/json',
                    },
                    body: JSON.stringify({
                        nombre, icono, campos,
                        global: document.getElementById('cat-global')?.checked ?? false,
                    }),
                });

                if (!res.ok) throw await res.json();
                const data = await res.json();

                /* Añadir al select y seleccionar */
                const opt = Object.assign(document.createElement('option'), {
                    value: data.id,
                    textContent: (data.icono ? data.icono + ' ' : '') + data.nombre,
                });
                opt.dataset.campos = JSON.stringify(data.campos || []);
                categoriaSelect.appendChild(opt);
                categoriaSelect.value = data.id;
                categoriaSelect.dispatchEvent(new Event('change'));

                /* Limpiar y cerrar */
                closeModal();
                camposList.innerHTML = '';
                document.getElementById('cat-nombre').value = '';
                document.getElementById('cat-icono').value  = '';

                if (window.showToast) window.showToast('Categoría creada correctamente.', 'success');
            } catch (err) {
                console.error(err);
                if (window.showToast) window.showToast('Error al crear la categoría.', 'error');
            } finally {
                btn.disabled = false;
                btn.style.opacity = '';
            }
        });

        /* ── Render campos dinámicos ── */
        categoriaSelect.addEventListener('change', () => {
            const opt    = categoriaSelect.options[categoriaSelect.selectedIndex];
            const campos = JSON.parse(opt.dataset.campos || '[]');
            renderCampos(campos, opt.textContent.trim());
        });

        function renderCampos(campos, catNombre) {
            camposDin.innerHTML = '';
            const stp3 = document.getElementById('stp-3');

            if (!campos.length) {
                secDinamica.style.display = 'none';
                stp3.style.opacity = '.35'; stp3.style.pointerEvents = 'none';
                return;
            }

            tituloDinamico.textContent = 'Atributos — ' + catNombre;
            secDinamica.style.display = 'block';
            stp3.style.opacity = '1'; stp3.style.pointerEvents = 'auto';

            campos.forEach(campo => {
                const wrap  = document.createElement('div');
                const label = document.createElement('label');
                label.className = 'nt-label';
                label.innerHTML = campo.label + (campo.requerido ? ' <span class="req">*</span>' : '');

                let input;
                if (campo.tipo === 'select' && campo.opciones) {
                    input = document.createElement('select');
                    input.className = 'nt-input nt-select';
                    input.innerHTML = '<option value="">Seleccionar…</option>';
                    const opts = Array.isArray(campo.opciones)
                        ? campo.opciones
                        : campo.opciones.split(',').map(o => o.trim()).filter(Boolean);
                    opts.forEach(op => {
                        const o = Object.assign(document.createElement('option'), { value: op, textContent: op });
                        if (oldAtributos[campo.clave] === op) o.selected = true;
                        input.appendChild(o);
                    });
                } else {
                    input = document.createElement('input');
                    input.type        = campo.tipo === 'number' ? 'number' : campo.tipo === 'date' ? 'date' : 'text';
                    input.value       = oldAtributos[campo.clave] || '';
                    input.placeholder = campo.label;
                    input.className   = 'nt-input';
                }

                input.name = `atributos[${campo.clave}]`;
                if (campo.requerido) input.required = true;

                wrap.appendChild(label);
                wrap.appendChild(input);
                camposDin.appendChild(wrap);
            });
        }

        /* Restaurar valor previo */
        if (categoriaSelect.value) {
            const opt = categoriaSelect.options[categoriaSelect.selectedIndex];
            renderCampos(JSON.parse(opt.dataset.campos || '[]'), opt.textContent.trim());
        }
    })();
    </script>
</x-app-layout>