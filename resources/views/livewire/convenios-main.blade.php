
<div class="w-full min-h-screen lg:pl-64">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col gap-6 mb-6">
            <h2 class="text-2xl font-bold text-[#003264] w-full">Gestión de Convenios</h2>

            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

                <div class="relative w-full md:w-2/3">
                    <input
                        type="text"
                        placeholder="Buscar convenios, entidades, documentos..."
                        class="w-full pl-4 pr-10 py-1.5 rounded-full border bg-white border-neutral-300 focus:outline-none focus:ring-2 focus:ring-[#003264] text-sm"
                        wire:model.live="search"
                    />
                    <!-- Span con breakpoints -->
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hidden lg:inline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                        </svg>
                    </span>
                </div>

                <a href="{{ route('convenios.create') }}"
                    class="w-full md:w-44 h-9 flex items-center justify-center border border-[#0097ff] text-white bg-[#0097ff] hover:bg-white hover:text-black rounded-full font-medium transition-all duration-200 ease-in-out transform hover:scale-105 text-sm gap-2">
                    <x-heroicon-o-plus class="w-6 h-6"/>
                    Nuevo Convenio
                </a>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out p-4 mb-6">
            <h3 class="text-lg font-semibold text-[#003264] mb-4">Filtros</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-[#5289C2] font-semibold text-sm mb-1">Entidad</label>
                    <select wire:model.live="filtro_entidad"
                        class="w-full rounded-xl border border-[#D9E2EC] px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-[#003264] transition ">
                        <option value="">Todas las entidades</option>
                        @foreach($entidades as $entidad)
                            <option value="{{ $entidad->id }}">{{ $entidad->nombreEntidad }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[#5289C2] font-semibold text-sm mb-1">Facultad</label>
                    <select wire:model.live="filtro_facultad"
                        class="w-full rounded-xl border border-[#D9E2EC] px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-[#003264] transition">
                        <option value="">Todas las facultades</option>
                        @foreach($facultades as $facultad)
                            <option value="{{ $facultad->id }}">{{ $facultad->nombreFacultad }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[#5289C2] font-semibold text-sm mb-1">Estado</label>
                    <select wire:model.live="filtro_estado"
                        class="w-full rounded-xl border border-[#D9E2EC] px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-[#003264] transition">
                        <option value="">Todos los estados</option>
                        <option value="Vigente">Vigente</option>
                        <option value="Por vencer">Por vencer</option>
                        <option value="Vencido">Vencido</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[#5289C2] font-semibold text-sm mb-1">Fecha de inicio</label>
                    <input type="date" wire:model.live="filtro_fecha_inicio"
                        class="w-full rounded-xl border border-[#D9E2EC] px-4 py-2 text-sm text-[#003264] focus:ring-2 focus:ring-blue-400 focus:border-[#003264] transition"
                        placeholder="DD/MM/AAAA">
                </div>
                <div>
                    <label class="block text-[#5289C2] font-semibold text-sm mb-1">Fecha de fin</label>
                    <input type="date" wire:model.live="filtro_fecha_fin"
                        class="w-full rounded-xl border border-[#D9E2EC] px-4 py-2 text-sm text-[#003264] focus:ring-2 focus:ring-blue-400] focus:border-[#003264] transition"
                        placeholder="DD/MM/AAAA">
                </div>
            </div>
        </div>

        <!-- Lista de convenios -->
        <div class="bg-white border border-[#003264] rounded-lg shadow-sm p-0">
            <div class="hidden md:grid grid-cols-9 gap-2 bg-white rounded-t-lg px-2 sm:px-4 py-2 font-semibold text-xs sm:text-sm text-[#003264] border-b border-[#D9E2EC]">
                <div class="truncate">Nombre</div>
                <div class="truncate">Estado</div>
                <div class="truncate">Fecha Inicio</div>
                <div class="truncate">Fecha Fin</div>
                <div class="truncate">Alcance</div>
                <div class="truncate">Entidad</div>
                <div class="truncate">Facultad</div>
                <div class="truncate">Carrera</div>
                <div class="truncate">Acciones</div>
            </div>
            <div class="divide-y divide-[#D9E2EC]">
                @forelse($convenios as $convenio)
                    <div wire:key="convenio-{{ $convenio->id }}" class="grid grid-cols-1 md:grid-cols-9 gap-2 items-center px-2 sm:px-4 py-3 hover:bg-[#F6F8FB] text-xs sm:text-sm">
                        <!-- Nombre -->
                        <div class="break-words whitespace-normal min-w-0" title="{{ $convenio->nombreConvenio }}">
                            <span class="md:hidden font-semibold text-gray-500">Nombre: </span>
                            <span class="font-medium">{{ $convenio->nombreConvenio }}</span>
                        </div>
                        <!-- Estado -->
                        <div>
                            <span class="md:hidden font-semibold text-gray-500">Estado: </span>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold
                                @if($convenio->estado == 'Vigente')
                                    bg-[#E6F7F1] text-[#1CA97A]
                                @elseif($convenio->estado == 'Por vencer')
                                    bg-[#FFF8E1] text-[#F6A700]
                                @else
                                    bg-[#FDEAEA] text-[#E14C4C]
                                @endif
                            ">
                                {{ $convenio->estado }}
                            </span>
                        </div>
                        <!-- Fecha Inicio -->
                        <div class="break-words whitespace-normal min-w-0">
                            <span class="md:hidden font-semibold text-gray-500">Inicio: </span>
                            <span>{{ Carbon\Carbon::parse($convenio->fecha_inicio)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</span>
                        </div>
                        <!-- Fecha Fin -->
                        <div class="break-words whitespace-normal min-w-0">
                            <span class="md:hidden font-semibold text-gray-500">Fin: </span>
                            <span>{{ Carbon\Carbon::parse($convenio->fecha_fin)->format('Y-m-d') }}</span>
                        </div>
                        <!-- Alcance -->
                        <div class="break-words whitespace-normal min-w-0">
                            <span class="md:hidden font-semibold text-gray-500">Alcance: </span>
                            <span>{{ $convenio->alcance }}</span>
                        </div>
                        <!-- Entidad -->
                        <div class="break-words whitespace-normal min-w-0" title="{{ $convenio->entidad->nombreEntidad ?? '' }}">
                            <span class="md:hidden font-semibold text-gray-500">Entidad: </span>
                            <span>{{ $convenio->entidad->nombreEntidad ?? '' }}</span>
                        </div>
                        <!-- Facultad -->
                        <div class="break-words whitespace-normal min-w-0" title="{{ $convenio->facultad->nombreFacultad ?? '' }}">
                            <span class="md:hidden font-semibold text-gray-500">Facultad: </span>
                            <span>{{ $convenio->facultad->nombreFacultad ?? '' }}</span>
                        </div>
                        <!-- Carrera -->
                        <div class="break-words whitespace-normal min-w-0" title="{{ $convenio->carrera->nombreCarrera ?? '' }}">
                            <span class="md:hidden font-semibold text-gray-500">Carrera: </span>
                            <span>{{ $convenio->carrera->nombreCarrera ?? '' }}</span>
                        </div>
                        <!-- Acciones -->
                        <div class="flex flex-wrap gap-1 justify-start md:justify-center mt-2 md:mt-0">
                            <a href="{{ route('convenios.detalle', $convenio->id) }}"
                               class="text-[#1CA97A] hover:text-[#005B8F] p-2 rounded-full hover:bg-[#E6F7F1] transition"
                               title="Ver detalles">
                                <x-heroicon-o-eye class="w-7 h-7"/>
                            </a>
                            <a href="{{ route('convenios.edit', $convenio->id) }}" class="text-[#005B8F] hover:text-white p-2 rounded-full hover:bg-[#005B8F] transition">
                                <x-heroicon-o-pencil-square class="w-7 h-7"/>
                            </a>
                            <button wire:click="delete({{ $convenio->id }})" class="text-[#E14C4C] hover:text-white p-2 rounded-full hover:bg-[#E14C4C] transition">
                                <x-heroicon-o-trash class="w-7 h-7"/>
                            </button>
                            <button wire:click="openEditArchivosModal({{ $convenio->id }})" class="text-[#F6A700] hover:text-white p-2 rounded-full hover:bg-[#F6A700] transition" title="Editar archivos">
                                <x-heroicon-o-paper-clip class="w-7 h-7"/>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-gray-500">No hay convenios registrados.</div>
                @endforelse
            </div>
            <div class="mt-4 px-4 pb-4">
                {{ $convenios->links() }}
            </div>
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
                                <label class="block text-sm font-medium">Entidad</label>
                                <select wire:model.live="convenio_id_entidad" class="w-full border rounded px-3 py-2 text-sm">
                                    <option value="">Seleccione</option>
                                    @foreach($entidades as $entidad)
                                        <option value="{{ $entidad->id }}">{{ $entidad->nombreEntidad }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Alcance</label>
                                <select wire:model.live="alcance" class="w-full border rounded px-3 py-2 text-sm">
                                    <option value="">Seleccione</option>
                                    <option value="Carrera">Carrera</option>
                                    <option value="Facultad">Facultad</option>
                                    <option value="Universidad">Universidad</option>
                                </select>
                            </div>
                            @if($alcance === 'Carrera' || $alcance === 'Facultad')
                                <div>
                                    <label class="block text-sm font-medium">Facultad</label>
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
                                    <label class="block text-sm font-medium">Carrera</label>
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
</div>