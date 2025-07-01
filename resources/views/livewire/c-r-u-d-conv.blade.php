<div class="max-w-5xl mx-auto py-6">
    <form wire:submit.prevent="save" class="bg-white rounded-lg shadow-lg p-8 space-y-8">
        <h2 class="text-2xl font-bold text-[#003264] mb-4">{{ $convenioId ? 'Editar Convenio' : 'Crear Convenio' }}</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Columna izquierda -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-[#003264] mb-1">Nombre del convenio</label>
                    <input type="text" wire:model="nombreConvenio" class="form-input w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#0097ff] focus:outline-none" placeholder="Ingrese el nombre del convenio" />
                    @error('nombreConvenio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#003264] mb-1">Entidad</label>
                    <select wire:model="convenio_id_entidad" class="form-input w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#0097ff] focus:outline-none">
                        <option value="">Seleccione una entidad</option>
                        @foreach($entidades as $entidad)
                            <option value="{{ $entidad->id }}">{{ $entidad->nombreEntidad }}</option>
                        @endforeach
                    </select>
                    @error('convenio_id_entidad') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#003264] mb-1">Descripción</label>
                    <textarea wire:model="descripcion" class="form-input w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#0097ff] focus:outline-none" rows="3" placeholder="Ingrese una descripción del convenio"></textarea>
                    @error('descripcion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Columna derecha -->
            <div class="space-y-6">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="w-full sm:w-1/2">
                        <label class="block text-sm font-semibold text-[#003264] mb-1">Fecha de inicio</label>
                        <input type="date" wire:model="fecha_inicio" class="form-input w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#0097ff] focus:outline-none" />
                        @error('fecha_inicio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-full sm:w-1/2">
                        <label class="block text-sm font-semibold text-[#003264] mb-1">Fecha de finalización</label>
                        <input type="date" wire:model="fecha_fin" class="form-input w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#0097ff] focus:outline-none" />
                        @error('fecha_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#003264] mb-1">Alcance</label>
                    <select wire:model.live="alcance" class="form-input w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#0097ff] focus:outline-none">
                        <option value="">Seleccione el alcance</option>
                        <option value="Carrera">Carrera</option>
                        <option value="Facultad">Facultad</option>
                        <option value="Universidad">Universidad</option>
                    </select>
                    @error('alcance') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                @if($alcance === 'Carrera' || $alcance === 'Facultad')
                <div>
                    <label class="block text-sm font-semibold text-[#003264] mb-1">Facultad</label>
                    <select wire:model="facultad_id" class="form-input w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#0097ff] focus:outline-none">
                        <option value="">Seleccione una facultad</option>
                        @foreach($facultades as $facultad)
                            <option value="{{ $facultad->id }}">{{ $facultad->nombreFacultad }}</option>
                        @endforeach
                    </select>
                    @error('facultad_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                @endif
                @if($alcance === 'Carrera')
                <div>
                    <label class="block text-sm font-semibold text-[#003264] mb-1">Carrera</label>
                    <select wire:model.live="carrera_id" class="form-input w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#0097ff] focus:outline-none">
                        <option value="">Seleccione la carrera</option>
                        @foreach($carreras as $carrera)
                            <option value="{{ $carrera->id }}">{{ $carrera->nombreCarrera }}</option>
                        @endforeach
                    </select>
                    @error('carrera_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                @endif
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-4 mt-8">
            <button type="button" onclick="window.history.back()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 hover:text-gray-900 transition text-sm">Cancelar</button>
            <button type="submit" class="px-4 py-2 bg-[#0097ff] text-white rounded-lg hover:bg-[#007acc] transition text-sm">Guardar</button>
        </div>
    </form>

    <!-- Documentos -->
    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 mt-6">
        <label class="block text-lg font-semibold text-[#003264] mb-4">Documentos</label>
        <p class="text-sm text-gray-500 mb-4">Puede adjuntar documentos relacionados con el convenio.</p>
        <!-- Archivos guardados -->
        @if($archivos_guardados)
            <div class="space-y-4 mb-4">
                @foreach($archivos_guardados as $doc)
                    <div class="flex items-center gap-4 bg-white rounded-lg shadow px-4 py-2">
                        <span class="truncate text-sm">{{ $doc['nombreArchivo'] }}</span>
                        <a href="{{ route('clausulas.descargar', $doc['id']) }}" target="_blank" class="text-blue-600 hover:text-blue-800 transition" title="Descargar archivo">
                            <x-heroicon-o-arrow-down-tray class="w-5 h-5"/>
                        </a>
                        <button type="button"
                            class="text-red-600 hover:text-red-800 transition"
                            wire:click="eliminarArchivoGuardado({{ $doc['id'] }})"
                            title="Eliminar archivo">
                            <x-heroicon-o-trash class="w-5 h-5"/>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Uploader fuera del form -->
        <livewire:documento-uploader :convenio-id="$convenioId" />
    </div>
</div>
