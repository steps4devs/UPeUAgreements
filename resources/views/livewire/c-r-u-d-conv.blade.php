<div class="min-h-screen w-full bg-[#EEF1F6] pt-2 px-2">
    <div class="max-w-5xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-2">
            Dashboard &gt; Convenios &gt; <span class="font-bold text-[#003264]">{{ $convenioId ? 'Editar Convenio' : 'Crear Convenio' }}</span>
        </nav>
        <form wire:submit.prevent="save" class="bg-white rounded-lg p-6 border shadow-blue-400 shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
            <h2 class="text-2xl font-bold mb-6 text-[#003264]">{{ $convenioId ? 'Editar Convenio' : 'Crear Convenio' }}</h2>

            <!-- Nombre del convenio -->
            <div class="mb-4">
                <label class="block text-[#003264] font-bold mb-1">Nombre del convenio</label>
                <input type="text" wire:model="nombreConvenio" class="w-full border border-[#DEDAFF] rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-[#003264] text-sm hover:shadow-sm transition-shadow duration-300 ease-in-out" placeholder="Ingrese el nombre del convenio" />
                @error('nombreConvenio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Primera fila: Entidad, Fecha de inicio, Fecha de finalización -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-[#003264] font-bold mb-1">Entidad</label>
                    <div class="flex items-center gap-2">
                        <select wire:model="convenio_id_entidad" class="w-full border border-[#DEDAFF] rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-[#003264] text-sm hover:shadow-sm transition-shadow duration-300 ease-in-out">
                            <option value="">Seleccione una entidad</option>
                            @foreach($entidades as $entidad)
                                <option value="{{ $entidad->id }}">{{ $entidad->nombreEntidad }}</option>
                            @endforeach
                        </select>
                        <button type="button" wire:click="openEntidadForm" class="px-4 py-2 bg-[#0097ff] text-white rounded-lg hover:bg-[#007acc] transition text-sm">
                            Crear Entidad
                        </button>
                    </div>
                    @error('convenio_id_entidad') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-[#003264] font-bold mb-1">Fecha de inicio</label>
                    <input type="date" wire:model="fecha_inicio" class="w-full border border-[#DEDAFF] rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-[#003264] text-sm hover:shadow-sm transition-shadow duration-300 ease-in-out" placeholder="DD/MM/AAAA" />
                    @error('fecha_inicio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-[#003264] font-bold mb-1">Fecha de finalización</label>
                    <input type="date" wire:model="fecha_fin" class="w-full border border-[#DEDAFF] rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-[#003264] text-sm hover:shadow-sm transition-shadow duration-300 ease-in-out" placeholder="DD/MM/AAAA" />
                    @error('fecha_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Segunda fila: Alcance, Facultades, Carreras -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-[#003264] font-bold mb-1">Alcance</label>
                    <select wire:model.live="alcance" class="w-full border border-[#DEDAFF] rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-[#003264] text-sm hover:shadow-sm transition-shadow duration-300 ease-in-out">
                        <option value="">Seleccione el alcance</option>
                        <option value="Carrera">Carrera</option>
                        <option value="Facultad">Facultad</option>
                        <option value="Universidad">Universidad</option>
                    </select>
                    @error('alcance') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    @if($alcance === 'Carrera' || $alcance === 'Facultad')
                        <label class="block text-[#003264] font-bold mb-1">Facultades</label>
                        <select wire:model.live="facultad_id" class="w-full border border-[#DEDAFF] rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-[#003264] text-sm hover:shadow-sm transition-shadow duration-300 ease-in-out">
                            <option value="">Seleccione una facultad</option>
                            @foreach($facultades as $facultad)
                                <option value="{{ $facultad->id }}">{{ $facultad->nombreFacultad }}</option>
                            @endforeach
                        </select>
                        @error('facultad_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    @endif
                </div>
                <div>
                    @if($alcance === 'Carrera')
                        <label class="block text-[#003264] font-bold mb-1">Carreras</label>
                        <select wire:model.live="carrera_id" class="w-full border border-[#DEDAFF] rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-[#003264] text-sm hover:shadow-sm transition-shadow duration-300 ease-in-out">
                            <option value="">Seleccione las carreras</option>
                            @foreach($carreras as $carrera)
                                <option value="{{ $carrera->id }}">{{ $carrera->nombreCarrera }}</option>
                            @endforeach
                        </select>
                        @error('carrera_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    @endif
                </div>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label class="block text-[#003264] font-bold mb-1">Descripción</label>
                <textarea wire:model="descripcion" class="w-full border border-[#DEDAFF] rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-[#003264] text-sm hover:shadow-sm transition-shadow duration-300 ease-in-out" rows="3" placeholder="Ingrese una descripción del convenio"></textarea>
                @error('descripcion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-4 mb-6">
                <button type="button"
                    onclick="window.history.back()"
                    class="px-6 py-2 border-2 border-[#E14C4C] text-black rounded-full text-sm transition hover:bg-[#E14C4C] hover:text-white duration-200 ease-in-out transform hover:scale-105">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-2 border-2 border-[#5AC97A] text-black rounded-full text-sm transition hover:bg-[#5AC97A] hover:text-white duration-200 ease-in-out transform hover:scale-105">
                    Guardar
                </button>
            </div>
        </form>

        @if($convenioId)
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 flex flex-col mt-6">
                <h3 class="font-bold text-lg mb-4 text-[#003264]">Documentos del Convenio</h3>

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
        @endif
    </div>
</div>