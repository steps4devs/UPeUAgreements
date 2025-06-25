<div class="w-full p-2 sm:p-4 md:p-6 bg-white rounded-lg shadow">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
        <h2 class="text-xl sm:text-2xl font-bold">Gestión de Convenios</h2>
        <a href="{{ route('convenios.create') }}"
           class="h-9 px-6 flex items-center justify-center border border-[#0097ff] bg-white text-black rounded-full font-medium transition text-sm hover:bg-[#eaf6ff]">
            <x-heroicon-o-plus class="w-5 h-5 mr-2"/>
            Nuevo Convenio
        </a>
    </div>

    <div class="flex flex-col sm:flex-row mb-4 gap-2">
        <input wire:model.live="search" type="text" placeholder="Buscar convenio..." class="border rounded px-3 py-2 w-full sm:w-1/3 text-sm">
        <select wire:model="perPage" class="border rounded px-2 py-2 w-24 text-sm">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
        </select>
    </div>

    <!-- Encabezados (solo desktop) -->
    <div class="hidden md:grid grid-cols-9 gap-2 bg-gray-100 rounded-t-lg px-2 sm:px-4 py-2 font-semibold text-xs sm:text-sm">
        <div>Nombre</div>
        <div>Estado</div>
        <div>Fecha Inicio</div>
        <div>Fecha Fin</div>
        <div>Alcance</div>
        <div>Entidad</div>
        <div>Facultad</div>
        <div>Carrera</div>
        <div>Acciones</div>
    </div>

    <!-- Filas -->
    <div class="divide-y">
        @forelse($convenios as $convenio)
            <div wire:key="convenio-{{ $convenio->id }}" class="grid grid-cols-1 md:grid-cols-9 gap-2 items-center px-2 sm:px-4 py-3 hover:bg-gray-50 text-xs sm:text-sm">
                <!-- Nombre -->
                <div>
                    <span class="md:hidden font-semibold text-gray-500">Nombre: </span>
                    <span class="font-medium">{{ $convenio->nombreConvenio }}</span>
                </div>
                <!-- Estado -->
                <div>
                    <span class="md:hidden font-semibold text-gray-500">Estado: </span>
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs
                        {{ $convenio->estado == 'Vigente' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        {{ $convenio->estado }}
                    </span>
                </div>
                <!-- Fecha Inicio -->
                <div>
                    <span class="md:hidden font-semibold text-gray-500">Inicio: </span>
                    <span>{{ $convenio->fecha_inicio }}</span>
                </div>
                <!-- Fecha Fin -->
                <div>
                    <span class="md:hidden font-semibold text-gray-500">Fin: </span>
                    <span>{{ $convenio->fecha_fin }}</span>
                </div>
                <!-- Alcance -->
                <div>
                    <span class="md:hidden font-semibold text-gray-500">Alcance: </span>
                    <span>{{ $convenio->alcance }}</span>
                </div>
                <!-- Entidad -->
                <div>
                    <span class="md:hidden font-semibold text-gray-500">Entidad: </span>
                    <span>{{ $convenio->entidad->nombreEntidad ?? '' }}</span>
                </div>
                <!-- Facultad -->
                <div>
                    <span class="md:hidden font-semibold text-gray-500">Facultad: </span>
                    <span>{{ $convenio->facultad->nombreFacultad ?? '' }}</span>
                </div>
                <!-- Carrera -->
                <div>
                    <span class="md:hidden font-semibold text-gray-500">Carrera: </span>
                    <span>{{ $convenio->carrera->nombreCarrera ?? '' }}</span>
                </div>
                <!-- Acciones -->
                <div class="flex gap-1 justify-start md:justify-center mt-2 md:mt-0">
                    <a href="{{ route('convenios.detalle', $convenio->id) }}"
                       class="text-green-600 hover:text-green-900 p-2 rounded-full hover:bg-green-100 transition"
                       title="Ver detalles">
                        <x-heroicon-o-eye class="w-7 h-7"/>
                    </a>
                    <a href="{{ route('convenios.edit', $convenio->id) }}" class="text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-100 transition">
                        <x-heroicon-o-pencil-square class="w-7 h-7"/>
                    </a>
                    <button wire:click="delete({{ $convenio->id }})" class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-100 transition">
                        <x-heroicon-o-trash class="w-7 h-7"/>
                    </button>
                    <button wire:click="openEditArchivosModal({{ $convenio->id }})" class="text-yellow-600 hover:text-yellow-900 p-2 rounded-full hover:bg-yellow-100 transition" title="Editar archivos">
                        <x-heroicon-o-paper-clip class="w-7 h-7"/>
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-4 text-gray-500">No hay convenios registrados.</div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $convenios->links() }}
    </div>

    <!-- Modal -->
    @if($modalOpen)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl font-semibold mb-4">{{ $editing ? 'Editar Convenio' : 'Nuevo Convenio' }}</h3>
            <form wire:submit.prevent="save" class="space-y-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium">Nombre</label>
                            <input wire:model.defer="nombreConvenio" type="text" class="w-full border rounded px-3 py-2 text-sm">
                            @error('nombreConvenio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Descripción</label>
                            <input wire:model.defer="descripcion" type="text" class="w-full border rounded px-3 py-2 text-sm">
                            @error('descripcion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <div class="w-full sm:w-1/2">
                                <label class="block text-sm font-medium">Fecha Inicio</label>
                                <input wire:model.defer="fecha_inicio" type="date" class="w-full border rounded px-3 py-2 text-sm">
                                @error('fecha_inicio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full sm:w-1/2">
                                <label class="block text-sm font-medium">Fecha Fin</label>
                                <input wire:model.defer="fecha_fin" type="date" class="w-full border rounded px-3 py-2 text-sm">
                                @error('fecha_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <label>Alcance</label>
                            <select wire:model.live="alcance" class="w-full border rounded px-3 py-2 text-sm">
                                <option value="">Seleccione</option>
                                <option value="Carrera">Carrera</option>
                                <option value="Facultad">Facultad</option>
                                <option value="Universidad">Universidad</option>
                            </select>
                        </div>
                        <div>
                            <label>Entidad</label>
                            <select wire:model.live="convenio_id_entidad" class="w-full border rounded px-3 py-2 text-sm">
                                <option value="">Seleccione</option>
                                @foreach($entidades as $entidad)
                                    <option value="{{ $entidad->id }}">{{ $entidad->nombreEntidad }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($alcance === 'Carrera' || $alcance === 'Facultad')
                            <div>
                                <label>Facultad</label>
                                <select wire:model.live="facultad_id" class="w-full border rounded px-3 py-2 text-sm">
                                    <option value="">Seleccione</option>
                                    @foreach($facultades as $facultad)
                                        <option value="{{ $facultad->id }}">{{ $facultad->nombreFacultad }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        @if($alcance === 'Carrera')
                            <div>
                                <label>Carrera</label>
                                <select wire:model.live="carrera_id" class="w-full border rounded px-3 py-2 text-sm">
                                    <option value="">Seleccione</option>
                                    @foreach($carreras as $carrera)
                                        <option value="{{ $carrera->id }}">{{ $carrera->nombreCarrera }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                    <!-- Espacio para subir archivos de cláusulas -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 flex flex-col">
                        <label class="block text-sm font-medium mb-2">Cláusulas (archivos)</label>
                        <input type="file" multiple wire:model="clausulas" id="clausulas" class="mb-2">

                        <!-- Barra de progreso -->
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

                        @error('clausulas.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        @if (session()->has('error'))
                            <span class="text-red-500 text-xs">{{ session('error') }}</span>
                        @endif

                        @if($clausulas_acumuladas)
                            <div class="space-y-2 mt-2">
                                @foreach($clausulas_acumuladas as $key => $archivo)
                                    <div class="flex items-center gap-2 bg-white rounded shadow px-2 py-1">
                                        <x-heroicon-o-document class="w-5 h-5"/>
                                        <span class="truncate text-xs">{{ $archivo->getClientOriginalName() }}</span>
                                        <!-- Descargar archivo -->
                                        @php
                                            $previewable = false;
                                            $ext = strtolower(pathinfo($archivo->getClientOriginalName(), PATHINFO_EXTENSION));
                                            if (in_array($ext, ['pdf', 'png', 'jpg', 'jpeg', 'gif', 'bmp', 'webp'])) {
                                                $previewable = true;
                                            }
                                        @endphp

                                        @if($previewable)
                                            <a href="{{ $archivo->temporaryUrl() }}" target="_blank" class="text-blue-600 hover:text-blue-800" title="Descargar archivo">
                                                <x-heroicon-o-arrow-down-tray class="w-5 h-5"/>
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs">No disponible para descarga directa</span>
                                        @endif
                                        <!-- Eliminar archivo -->
                                        <button type="button"
                                            class="text-red-600 hover:text-red-800"
                                            wire:click="eliminarArchivo({{ $key }})"
                                            title="Eliminar archivo">
                                            <x-heroicon-o-trash class="w-5 h-5"/>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <span class="text-xs text-gray-400 mt-2">Puedes subir varios archivos PDF, DOC, DOCX.</span>
                    </div>
                </div>
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" wire:click="cerrarModal" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">{{ $editing ? 'Actualizar' : 'Guardar' }}</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($modalEditArchivosOpen)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-4">
            <h3 class="text-lg font-semibold mb-4">Editar Archivos del Convenio</h3>
            <!-- Archivos guardados -->
            @if($archivos_guardados)
                <div class="space-y-2 mb-4">
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

            <!-- Subir nuevos archivos -->
            <input type="file" multiple wire:model="clausulas" class="mb-2">
            @error('clausulas.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            @if($clausulas_acumuladas)
                <div class="space-y-2 mt-2">
                    @foreach($clausulas_acumuladas as $key => $archivo)
                        <div class="flex items-center gap-2 bg-white rounded shadow px-2 py-1">
                            <x-heroicon-o-document class="w-5 h-5"/>
                            <span class="truncate text-xs">{{ $archivo->getClientOriginalName() }}</span>
                            <button type="button"
                                class="text-red-600 hover:text-red-800"
                                wire:click="eliminarArchivo({{ $key }})"
                                title="Eliminar archivo">
                                <x-heroicon-o-trash class="w-5 h-5"/>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" wire:click="cerrarModalEditArchivos" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm">Cancelar</button>
                <button type="button" wire:click="guardarNuevosArchivos" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Guardar Cambios</button>
            </div>
        </div>
    </div>
    @endif

    @if($archivos_guardados)
        <div class="space-y-2 mt-2">
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
