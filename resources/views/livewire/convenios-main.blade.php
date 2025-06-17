<div class="w-full p-2 sm:p-4 md:p-6 bg-white rounded-lg shadow">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
        <h2 class="text-xl sm:text-2xl font-bold">Gestión de Convenios</h2>
        <button wire:click="openModal" class="flex items-center justify-center px-3 py-2 sm:px-4 sm:py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm sm:text-base">
            <svg class="w-6 h-6 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor"><use href="#heroicon-o-plus" /></svg>
            Nuevo Convenio
        </button>
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
                    <button wire:click="showDetails({{ $convenio->id }})" class="text-green-600 hover:text-green-900 p-2 rounded-full hover:bg-green-100 transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor"><use href="#heroicon-o-plus" /></svg>
                    </button>
                    <button wire:click="openModal({{ $convenio->id }})" class="text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-100 transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor"><use href="#heroicon-o-pencil-square" /></svg>
                    </button>
                    <button wire:click="delete({{ $convenio->id }})" class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-100 transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor"><use href="#heroicon-o-trash" /></svg>
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
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl font-semibold mb-4">{{ $editing ? 'Editar Convenio' : 'Nuevo Convenio' }}</h3>
            <form wire:submit.prevent="save" class="space-y-4">
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
                {{-- Elimina o comenta este bloque del formulario --}}
                {{-- 
                <div>
                    <label class="block text-sm font-medium">Estado</label>
                    <select wire:model.defer="estado" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">Seleccione</option>
                        <option value="Vigente">Vigente</option>
                        <option value="Vencido">Vencido</option>
                        <option value="Por vencer">Por vencer</option>
                    </select>
                    @error('estado') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                --}}
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
                {{-- Alcance --}}
                <div>
                    <label>Alcance</label>
                    <select wire:model.live="alcance" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">Seleccione</option>
                        <option value="Carrera">Carrera</option>
                        <option value="Facultad">Facultad</option>
                        <option value="Universidad">Universidad</option>
                    </select>
                </div>

                {{-- Entidad --}}
                <div>
                    <label>Entidad</label>
                    <select wire:model.live="convenio_id_entidad" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">Seleccione</option>
                        @foreach($entidades as $entidad)
                            <option value="{{ $entidad->id }}">{{ $entidad->nombreEntidad }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Facultad (solo si corresponde) --}}
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

                {{-- Carrera (solo si corresponde) --}}
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
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" wire:click="$set('modalOpen', false)" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">{{ $editing ? 'Actualizar' : 'Guardar' }}</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Heroicons SVGs -->
    <svg style="display:none;">
        <symbol id="heroicon-o-plus" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" d="M12 4v16m8-8H4"/></symbol>
        <symbol id="heroicon-o-pencil-square" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" d="M16.862 3.487a2.06 2.06 0 1 1 2.915 2.915l-9.193 9.193a2.06 2.06 0 0 1-.872.52l-3.25.93a.515.515 0 0 1-.638-.638l.93-3.25a2.06 2.06 0 0 1 .52-.872l9.193-9.193z"/><path stroke="currentColor" stroke-width="2" d="M19.5 14.25V19a2.25 2.25 0 0 1-2.25 2.25h-10.5A2.25 2.25 0 0 1 4.5 19V8.25A2.25 2.25 0 0 1 6.75 6h4.75"/></symbol>
        <symbol id="heroicon-o-trash" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" d="M6 7h12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m2 0v12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V7h12z"/></symbol>
    </svg>
</div>