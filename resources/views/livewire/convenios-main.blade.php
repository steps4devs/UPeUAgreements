<div class="flex flex-col gap-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-neutral-500 mb-2 flex items-center gap-2">
        <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
        <span>/</span>
        <span class="font-semibold text-black dark:text-white">Convenios</span>
        @if($action === 'create')
            <span>/</span>
            <span class="font-semibold text-black dark:text-white">Crear Convenio</span>
        @elseif($action === 'edit')
            <span>/</span>
            <span class="font-semibold text-black dark:text-white">Editar Convenio</span>
        @endif
    </nav>

    @if($action === 'create' || $action === 'edit')
        <!-- Formulario de Crear/Editar Convenio -->
        <div class="bg-white dark:bg-neutral-900 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700 max-w-4xl mx-auto">
            <h2 class="text-xl font-bold mb-4">
                {{ $action === 'edit' ? 'Editar Convenio' : 'Crear Convenio' }}
            </h2>
            <form wire:submit.prevent="{{ $action === 'edit' ? 'actualizarConvenio' : 'guardarConvenio' }}" class="space-y-6">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nombre del convenio</label>
                        <input type="text" wire:model="nombreConvenio" class="input input-bordered w-full" required />
                        @error('nombreConvenio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Entidad</label>
                        <div class="relative">
                            <input
                                type="text"
                                wire:model.debounce.300ms="entidad_search"
                                class="input input-bordered w-full"
                                placeholder="Buscar o crear entidad..."
                                autocomplete="off"
                            />
                            @if($entidad_search && count($entidad_suggestions))
                                <ul class="absolute z-10 bg-white border border-gray-200 w-full mt-1 rounded shadow">
                                    @foreach($entidad_suggestions as $entidad)
                                        <li wire:click="seleccionarEntidad({{ $entidad->id }})"
                                            class="px-4 py-2 hover:bg-blue-100 cursor-pointer">
                                            {{ $entidad->nombreEntidad }}
                                        </li>
                                    @endforeach
                                    <li wire:click="crearNuevaEntidad"
                                        class="px-4 py-2 hover:bg-green-100 cursor-pointer text-green-700 font-semibold">
                                        + Crear nueva entidad "<span class="italic">{{ $entidad_search }}</span>"
                                    </li>
                                </ul>
                            @endif
                            @error('entidad_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Descripción</label>
                    <textarea wire:model="descripcion" class="input input-bordered w-full" rows="2"></textarea>
                    @error('descripcion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Fecha de inicio</label>
                        <input type="date" wire:model="fecha_inicio" class="input input-bordered w-full" required />
                        @error('fecha_inicio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Fecha de finalización</label>
                        <input type="date" wire:model="fecha_fin" class="input input-bordered w-full" required />
                        @error('fecha_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Estado</label>
                        <select wire:model="estado" class="input input-bordered w-full" required>
                            <option value="">Seleccione el estado</option>
                            <option value="Vigente">Vigente</option>
                            <option value="Vencido">Vencido</option>
                            <option value="Por vencer">Por vencer</option>
                        </select>
                        @error('estado') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Alcance</label>
                        <select wire:model="alcance" class="input input-bordered w-full" required>
                            <option value="">Seleccione el alcance</option>
                            <option value="Carrera">Carrera</option>
                            <option value="Facultad">Facultad</option>
                            <option value="Universidad">Universidad</option>
                        </select>
                        @error('alcance') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Facultad</label>
                        <select wire:model="facultad_id" class="input input-bordered w-full" required>
                            <option value="">Seleccione una facultad</option>
                            @foreach($facultades as $facultad)
                                <option value="{{ $facultad->id }}">{{ $facultad->nombreFacultad }}</option>
                            @endforeach
                        </select>
                        @error('facultad_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Carrera</label>
                        <select wire:model="carrera_id" class="input input-bordered w-full" required>
                            <option value="">Seleccione la carrera</option>
                            @foreach($carreras as $carrera)
                                <option value="{{ $carrera->id }}">{{ $carrera->nombreCarrera }}</option>
                            @endforeach
                        </select>
                        @error('carrera_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" wire:click="cancelar" class="btn btn-outline">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        {{ $action === 'edit' ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </form>

            {{-- Formulario adicional para nueva entidad --}}
            @if($showEntidadForm)
                <div class="mt-4 p-4 border rounded bg-zinc-50 dark:bg-zinc-800">
                    <h3 class="font-semibold mb-2">Nueva Entidad</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Nombre</label>
                            <input type="text" wire:model="nuevaEntidad.nombreEntidad" class="input input-bordered w-full" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Ubicación</label>
                            <input type="text" wire:model="nuevaEntidad.ubicacion" class="input input-bordered w-full" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Contacto</label>
                            <input type="text" wire:model="nuevaEntidad.contacto" class="input input-bordered w-full" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Logo (URL o archivo)</label>
                            <input type="text" wire:model="nuevaEntidad.logo" class="input input-bordered w-full" />
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" wire:click="$set('showEntidadForm', false)" class="btn btn-outline">Cancelar</button>
                        <button type="button" wire:click="guardarEntidad" class="btn btn-primary">Guardar Entidad</button>
                    </div>
                </div>
            @endif
        </div>
    @else
        <!-- Tabla de Convenios -->
        <div class="bg-white dark:bg-neutral-900 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Convenios</h2>
                <a href="{{ route('convenios-main', ['action' => 'create']) }}" class="btn btn-primary">Nuevo Convenio</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-neutral-500">
                            <th class="py-2 px-2 text-left">NOMBRE</th>
                            <th class="py-2 px-2 text-left">ENTIDAD</th>
                            <th class="py-2 px-2 text-left">FACULTAD</th>
                            <th class="py-2 px-2 text-left">CARRERA</th>
                            <th class="py-2 px-2 text-left">FECHA INICIO</th>
                            <th class="py-2 px-2 text-left">FECHA FIN</th>
                            <th class="py-2 px-2 text-left">ESTADO</th>
                            <th class="py-2 px-2 text-left">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($convenios as $convenio)
                            <tr>
                                <td class="py-2 px-2">{{ $convenio->nombreConvenio }}</td>
                                <td class="py-2 px-2">{{ $convenio->entidad->nombreEntidad ?? '-' }}</td>
                                <td class="py-2 px-2">{{ $convenio->facultad->nombreFacultad ?? '-' }}</td>
                                <td class="py-2 px-2">{{ $convenio->carrera->nombreCarrera ?? '-' }}</td>
                                <td class="py-2 px-2">{{ \Carbon\Carbon::parse($convenio->fecha_inicio)->format('d/m/Y') }}</td>
                                <td class="py-2 px-2">{{ \Carbon\Carbon::parse($convenio->fecha_fin)->format('d/m/Y') }}</td>
                                <td class="py-2 px-2">
                                    @if($convenio->estado === 'Vigente')
                                        <span class="text-green-600 font-semibold">Vigente</span>
                                    @elseif($convenio->estado === 'Por vencer')
                                        <span class="text-orange-600 font-semibold">Por vencer</span>
                                    @else
                                        <span class="text-neutral-500 font-semibold">{{ $convenio->estado }}</span>
                                    @endif
                                </td>
                                <td class="py-2 px-2 flex gap-2">
                                    <button wire:click="editar({{ $convenio->id }})" class="btn btn-xs btn-outline">Editar</button>
                                    <button wire:click="eliminar({{ $convenio->id }})" class="btn btn-xs btn-outline text-red-600">Eliminar</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-4 text-center text-neutral-400">No hay convenios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
