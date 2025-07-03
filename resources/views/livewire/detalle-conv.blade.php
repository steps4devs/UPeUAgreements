<div class="w-full min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-1 text-[#003264]">Detalles del Convenio</h2>
                <nav class="text-sm text-gray-500 mb-2">
                    Dashboard &gt; Convenios &gt; <span class="font-semibold text-[#003264]">Detalles del Convenio</span>
                </nav>
            </div>
            <div class="flex gap-2 mt-2 md:mt-0">
                <button class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">Compartir</button>
                <button class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">Imprimir</button>
                <button class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">Exportar</button>
                <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Editar</button>
            </div>
        </div>

        <!-- Estado y fechas fuera del contenedor de Información General -->
        <div class="flex items-center gap-3 mb-4">
            <span class="inline-block w-3 h-3 rounded-full
                {{ $convenio->estado === 'Vigente' ? 'bg-green-500' : ($convenio->estado === 'Por vencer' ? 'bg-yellow-400' : 'bg-red-500') }}">
            </span>
            <span class="font-semibold text-base
                {{ $convenio->estado === 'Vigente' ? 'text-green-500' : ($convenio->estado === 'Por vencer' ? 'text-yellow-400' : 'text-red-500') }}">
                {{ $convenio->estado }}
            </span>
            <span class="text-xs text-gray-400 ml-2">Última actualización: {{ $convenio->updated_at->format('d/m/Y') }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Columna principal -->
            <div class="md:col-span-2 space-y-6">
                <!-- Información General -->
                <div class="bg-white rounded-lg p-6 border shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <h3 class="font-bold text-lg mb-2 text-[#003264]">Información General</h3>
                    <div class="mb-2">
                        <span class="block font-semibold text-[#003264]">Nombre del Convenio:</span>
                        <span class="block">{{ $convenio->nombreConvenio }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="block font-semibold text-[#003264]">Entidad Asociada:</span>
                        <span class="block">{{ $convenio->entidad->nombreEntidad ?? '-' }}</span>
                    </div>
                    <div class="mb-2">
                    <span class="block text-center font-semibold text-[#003264]">Ámbito de Aplicación:</span>

                    <div class="flex flex-col sm:flex-row gap-2 mt-2">
                        <select wire:model="ambito_1" wire:change="guardarAmbito(1)"
                            class="rounded-lg border border-[#e5e5a1] bg-[#FFF6B6] focus:ring-2 focus:ring-blue-400 px-2 py-1 shadow-sm transition text-sm w-40 max-w-[160px]">
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

                        <select wire:model="ambito_2" wire:change="guardarAmbito(2)"
                            class="rounded-lg border border-[#e5e5a1] bg-[#FFF6B6] focus:ring-2 focus:ring-blue-400 px-2 py-1 shadow-sm transition text-sm w-40 max-w-[160px]">
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

                        <select wire:model="ambito_3" wire:change="guardarAmbito(3)"
                            class="rounded-lg border border-[#e5e5a1] bg-[#FFF6B6] focus:ring-2 focus:ring-blue-400 px-2 py-1 shadow-sm transition text-sm w-40 max-w-[160px]">
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
                        <span class="block text-center font-semibold text-[#003264]">Descripción:</span>
                        <p class="text-gray-700">{{ $convenio->descripcion }}</p>
                    </div>
                </div>

                <!-- Documentos -->
                <div class="bg-white rounded-lg p-6 border shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <h3 class="font-bold text-lg mb-4 text-[#003264]">Documentos</h3>

                    <!-- Subir nuevos archivos -->
                    <div class="border-2 border-dashed border-[#DEDAFF] rounded-lg flex flex-col items-center justify-center py-10 px-4 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#003264] mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16v-8m0 0l-4 4m4-4l4 4M4 20h16" />
                        </svg>
                        <span class="block text-base text-[#003264] font-semibold mb-2">Arrastre y suelte archivos aquí o</span>
                        <input type="file" multiple wire:model="clausulas" class="hidden" id="clausulas">
                        <label for="clausulas" class="cursor-pointer inline-flex items-center justify-center w-full border border-neutral-300 rounded-lg px-4 py-2 bg-white text-sm text-[#003264] hover:bg-[#f0f8ff] hover:border-[#0097ff] transition">
                            Seleccionar archivos
                        </label>
                        @error('clausulas.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Mostrar barra de progreso -->
                    <div x-data="{ progress: 0 }"
                         x-on:livewire-upload-start="progress = 0"
                         x-on:livewire-upload-finish="progress = 0"
                         x-on:livewire-upload-error="progress = 0"
                         x-on:livewire-upload-progress="progress = $event.detail.progress"
                         class="w-full mt-2">
                        <template x-if="progress > 0">
                            <div class="w-full bg-gray-200 rounded h-2">
                                <div class="bg-blue-600 h-2 rounded" :style="'width: ' + progress + '%'"></div>
                            </div>
                        </template>
                    </div>

                    <!-- Mostrar documentos subidos -->
                    @if($archivos_guardados)
                        <div class="space-y-2 mt-4">
                            @foreach($archivos_guardados as $doc)
                                <div class="flex items-center gap-2 bg-white rounded shadow px-2 py-1">
                                    <x-heroicon-o-document class="w-5 h-5"/>
                                    <span class="truncate text-xs">{{ $doc['nombreArchivo'] }}</span>
                                    <a href="{{ route('clausulas.descargar', $doc['id']) }}" target="_blank" class="text-blue-600 hover:text-blue-800" title="Descargar archivo">
                                        <x-heroicon-o-arrow-down-tray class="w-5 h-5"/>
                                    </a>
                                    <button type="button"
                                        class="text-red-600 hover:text-red-800"
                                        wire:click="eliminarArchivoGuardado({{ $doc['id'] }})"
                                        title="Eliminar archivo">
                                        <x-heroicon-o-trash class="w-5 h-5"/>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Columna lateral -->
            <div class="space-y-6">
                <!-- Estado y Fechas lateral (elimina este bloque si ya está dentro de Información General) -->
                <div class="bg-green-50 rounded-lg shadow p-4 border border-[#003264]">
                    <div class="font-bold text-green-700 mb-2">Estado actual: {{ $convenio->estado }}</div>
                    <div class="text-sm mb-1 text-[#003264]">Fecha de inicio: <span class="font-semibold">{{ \Carbon\Carbon::parse($convenio->fecha_inicio)->format('d/m/Y') }}</span></div>
                    <div class="text-sm mb-1 text-[#003264]">Fecha de finalización: <span class="font-semibold">{{ $convenio->fecha_fin ? \Carbon\Carbon::parse($convenio->fecha_fin)->format('d/m/Y') : '-' }}</span></div>
                    <div class="text-xs text-gray-500">Tiempo restante:
                        @if($convenio->fecha_fin)
                            {{ \Carbon\Carbon::parse($convenio->fecha_fin)->locale('es')->diffForHumans(now(), ['parts' => 3, 'join' => true, 'short' => true, 'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]) }}
                        @else
                            Indefinido
                        @endif
                    </div>
                </div>

                <!-- Responsables -->
                <div class="bg-white rounded-lg shadow p-4 border border-[#003264]">
                    <div class="font-bold mb-2 text-[#003264]">Responsables</div>
                    <div class="mb-2">
                        <div class="font-semibold text-[#003264]">Coordinador Universidad</div>
                        <div class="text-sm text-gray-700">{{ $convenio->coordinador_universidad ?? '-' }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="font-semibold text-[#003264]">Coordinador Empresa</div>
                        <div class="text-sm text-gray-700">{{ $convenio->coordinador_empresa ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-[#003264]">Administrador del Convenio</div>
                        <div class="text-sm text-gray-700">{{ $convenio->administrador ?? '-' }}</div>
                    </div>
                </div>

                <!-- Facultades Involucradas -->
                <div class="bg-blue-50 rounded-lg shadow p-4 border border-[#003264]">
                    <div class="font-bold mb-2 text-[#003264]">Facultades Involucradas</div>
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
</div>