<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-1">Detalles del Convenio</h2>
            <nav class="text-sm text-gray-500 mb-2">
                Dashboard &gt; Convenios &gt; <span class="font-semibold text-gray-700">Detalles del Convenio</span>
            </nav>
        </div>
        <div class="flex gap-2 mt-2 md:mt-0">
            <button class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">Compartir</button>
            <button class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">Imprimir</button>
            <button class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">Exportar</button>
            <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Editar</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Columna principal -->
        <div class="md:col-span-2 space-y-6">
            <!-- Estado y fechas -->
            <div class="flex items-center gap-3">
                <span class="inline-block w-3 h-3 rounded-full {{ $convenio->estado === 'Vigente' ? 'bg-green-500' : ($convenio->estado === 'Por vencer' ? 'bg-yellow-400' : 'bg-red-500') }}"></span>
                <span class="font-semibold">{{ $convenio->estado }}</span>
                <span class="text-xs text-gray-400 ml-2">Última actualización: {{ $convenio->updated_at->format('d/m/Y') }}</span>
            </div>

            <!-- Información General -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-lg mb-2">Información General</h3>
                <div class="mb-2">
                    <span class="font-semibold">Nombre del Convenio:</span>
                    <span>{{ $convenio->nombreConvenio }}</span>
                </div>
                <div class="mb-2">
                    <span class="font-semibold">Entidad Asociada:</span>
                    <span>{{ $convenio->entidad->nombreEntidad ?? '-' }}</span>
                </div>
                <div class="mb-2">
                    <span class="font-semibold">Ámbito de Aplicación:</span>
                    <div class="flex flex-col sm:flex-row gap-2 mt-2">
                        <select wire:model="ambito_1" wire:change="guardarAmbito(1)" class="rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-400 px-3 py-2 shadow-sm transition">
                            <option value="">Selecciona ámbito 1</option>
                            @foreach([
                                'Investigación', 'Prácticas Profesionales', 'Transferencia Tecnológica', 'Movilidad Académica',
                                'Capacitación', 'Desarrollo de Proyectos', 'Intercambio Cultural', 'Responsabilidad Social',
                                'Innovación', 'Emprendimiento', 'Servicios Tecnológicos', 'Consultoría', 'Educación Continua',
                                'Desarrollo Sostenible', 'Vinculación Empresarial', 'Internacionalización', 'Publicaciones',
                                'Eventos Académicos', 'Otros'
                            ] as $ambito)
                                <option value="{{ $ambito }}">{{ $ambito }}</option>
                            @endforeach
                        </select>
                        <select wire:model="ambito_2" wire:change="guardarAmbito(2)" class="rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-400 px-3 py-2 shadow-sm transition">
                            <option value="">Selecciona ámbito 2</option>
                            @foreach([
                                'Investigación', 'Prácticas Profesionales', 'Transferencia Tecnológica', 'Movilidad Académica',
                                'Capacitación', 'Desarrollo de Proyectos', 'Intercambio Cultural', 'Responsabilidad Social',
                                'Innovación', 'Emprendimiento', 'Servicios Tecnológicos', 'Consultoría', 'Educación Continua',
                                'Desarrollo Sostenible', 'Vinculación Empresarial', 'Internacionalización', 'Publicaciones',
                                'Eventos Académicos', 'Otros'
                            ] as $ambito)
                                <option value="{{ $ambito }}">{{ $ambito }}</option>
                            @endforeach
                        </select>
                        <select wire:model="ambito_3" wire:change="guardarAmbito(3)" class="rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-400 px-3 py-2 shadow-sm transition">
                            <option value="">Selecciona ámbito 3</option>
                            @foreach([
                                'Investigación', 'Prácticas Profesionales', 'Transferencia Tecnológica', 'Movilidad Académica',
                                'Capacitación', 'Desarrollo de Proyectos', 'Intercambio Cultural', 'Responsabilidad Social',
                                'Innovación', 'Emprendimiento', 'Servicios Tecnológicos', 'Consultoría', 'Educación Continua',
                                'Desarrollo Sostenible', 'Vinculación Empresarial', 'Internacionalización', 'Publicaciones',
                                'Eventos Académicos', 'Otros'
                            ] as $ambito)
                                <option value="{{ $ambito }}">{{ $ambito }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="text-xs text-gray-400 mt-1 block">Se guarda automáticamente al seleccionar.</span>
                    @if($mensaje)
                        <div 
                            x-data="{ show: true }"
                            x-init="setTimeout(() => show = false, 2000)"
                            x-show="show"
                            class="mt-2 px-3 py-2 rounded bg-green-100 text-green-800 text-sm shadow transition"
                        >
                            {{ $mensaje }}
                        </div>
                    @endif
                </div>
                <div class="mb-2">
                    <span class="font-semibold">Descripción:</span>
                    <p class="text-gray-700">{{ $convenio->descripcion }}</p>
                </div>
            </div>

            <!-- Documentos -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-lg mb-2">Documentos</h3>
                @forelse($convenio->documentos as $doc)
                    @php
                        $ext = strtolower(pathinfo($doc->nombreArchivo, PATHINFO_EXTENSION));
                    @endphp
                    <div class="flex items-center gap-3 mb-2">
                        <span class="inline-block w-8 h-8 bg-gray-100 rounded flex items-center justify-center">
                            @if($ext === 'pdf')
                                <x-heroicon-o-document-text class="w-5 h-5 text-red-500"/>
                            @elseif(in_array($ext, ['doc', 'docx']))
                                <x-heroicon-o-document-text class="w-5 h-5 text-blue-700"/>
                            @elseif(in_array($ext, ['xls', 'xlsx']))
                                <x-heroicon-o-document-text class="w-5 h-5 text-green-600"/>
                            @elseif(in_array($ext, ['ppt', 'pptx']))
                                <x-heroicon-o-document-text class="w-5 h-5 text-orange-500"/>
                            @elseif(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                <x-heroicon-o-photo class="w-5 h-5 text-purple-500"/>
                            @else
                                <x-heroicon-o-document class="w-5 h-5 text-gray-400"/>
                            @endif
                        </span>
                        <div>
                            <div class="font-semibold">{{ $doc->nombreArchivo }}</div>
                            <div class="text-xs text-gray-500">{{ $doc->tipo_documento }} &middot; Subido el {{ \Carbon\Carbon::parse($doc->fecha_subida)->format('d/m/Y') }}</div>
                        </div>
                        <a href="{{ route('clausulas.descargar', $doc->id) }}" target="_blank" class="ml-auto text-blue-600 hover:text-blue-800" title="Descargar archivo">
                            <x-heroicon-o-arrow-down-tray class="w-5 h-5"/>
                        </a>
                        <form method="POST" action="{{ route('clausulas.eliminar', $doc->id) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 ml-2" title="Eliminar archivo">
                                <x-heroicon-o-trash class="w-5 h-5"/>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="text-gray-500">No hay documentos adjuntos.</div>
                @endforelse
            </div>
        </div>

        <!-- Columna lateral -->
        <div class="space-y-6">
            <!-- Estado y Fechas -->
            <div class="bg-green-50 rounded-lg shadow p-4">
                <div class="font-bold text-green-700 mb-2">Estado actual: {{ $convenio->estado }}</div>
                <div class="text-sm mb-1">Fecha de inicio: <span class="font-semibold">{{ \Carbon\Carbon::parse($convenio->fecha_inicio)->format('d/m/Y') }}</span></div>
                <div class="text-sm mb-1">Fecha de finalización: <span class="font-semibold">{{ $convenio->fecha_fin ? \Carbon\Carbon::parse($convenio->fecha_fin)->format('d/m/Y') : '-' }}</span></div>
                <div class="text-xs text-gray-500">Tiempo restante: 
                    @if($convenio->fecha_fin)
                        {{ \Carbon\Carbon::parse($convenio->fecha_fin)->locale('es')->diffForHumans(now(), ['parts' => 3, 'join' => true, 'short' => true, 'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]) }}
                    @else
                        Indefinido
                    @endif
                </div>
            </div>

            <!-- Responsables -->
            <div class="bg-white rounded-lg shadow p-4">
                <div class="font-bold mb-2">Responsables</div>
                <div class="mb-2">
                    <div class="font-semibold">Coordinador Universidad</div>
                    <div class="text-sm text-gray-700">{{ $convenio->coordinador_universidad ?? '-' }}</div>
                </div>
                <div class="mb-2">
                    <div class="font-semibold">Coordinador Empresa</div>
                    <div class="text-sm text-gray-700">{{ $convenio->coordinador_empresa ?? '-' }}</div>
                </div>
                <div>
                    <div class="font-semibold">Administrador del Convenio</div>
                    <div class="text-sm text-gray-700">{{ $convenio->administrador ?? '-' }}</div>
                </div>
            </div>

            <!-- Facultades Involucradas -->
            <div class="bg-blue-50 rounded-lg shadow p-4">
                <div class="font-bold mb-2">Facultades Involucradas</div>
                @if($convenio->facultad)
                    <div class="text-sm">{{ $convenio->facultad->nombreFacultad }}</div>
                @else
                    <div class="text-gray-500 text-sm">No hay facultades asociadas.</div>
                @endif
            </div>
        </div>
    </div>
    <div class="mt-6 flex">
        <a href="{{ route('convenios-main') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-semibold shadow">
            <x-heroicon-o-arrow-left class="w-5 h-5 mr-2"/>
            Volver al Listado
        </a>
    </div>

    {{-- Notificaciones apiladas --}}
    <div 
        x-data="{
            notificaciones: [],
            init() {
                window.addEventListener('notificar', e => {
                    this.notificaciones.push({ id: Date.now() + Math.random(), message: e.detail.message });
                });
            }
        }"
        class="fixed top-4 right-4 z-50 flex flex-col items-end space-y-2"
        style="min-width: 250px;"
    >
        <template x-for="(notif, idx) in notificaciones" :key="notif.id">
            <div 
                x-show="true"
                x-transition
                x-init="setTimeout(() => notificaciones.splice(idx, 1), 3000)"
                class="mb-2 px-4 py-2 rounded bg-green-100 text-green-800 text-sm shadow-lg min-w-[220px]"
            >
                <span x-text="notif.message"></span>
            </div>
        </template>
    </div>
</div>
