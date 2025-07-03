<div class="min-h-screen w-full bg-[#EEF1F6] pt-2 px-2">
    <div class="max-w-5xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-2">
            Dashboard &gt; Convenios &gt; <span class="font-bold text-[#003264]">Crear Convenio</span>
        </nav>
        <form wire:submit.prevent="save" class="bg-white rounded-lg p-6 border shadow-blue-400 shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
            <h2 class="text-2xl font-bold mb-6 text-[#003264]">Crear Convenio</h2>

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

            <!-- Documentos dentro del mismo div -->
            <div class="bg-white rounded-lg p-0 mt-[-20px]">
                <label class="block text-[#003264] text-base font-bold mb-2">Documentos</label>
                <p class="text-xs text-gray-500 mb-3">Puede adjuntar documentos relacionados con el convenio después de guardar los datos básicos.</p>
                <div class="border-2 border-dashed border-[#DEDAFF] rounded-lg flex flex-col items-center justify-center py-10 px-4 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#003264] mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16v-8m0 0l-4 4m4-4l4 4M4 20h16" />
                    </svg>
                    <span class="block text-base text-[#003264] font-semibold mb-2">Arrastre y suelte archivos aquí o</span>
                    <div class="w-full flex flex-col items-center">
                        {{-- Aquí se renderiza el uploader real --}}
                        <livewire:documento-uploader :convenio-id="$convenioId" />
                    </div>
                    <span class="block text-xs text-gray-500 mt-2">Primero debe guardar el convenio para poder adjuntar documentos</span>
                </div>
                @if($archivos_guardados)
                    <div class="space-y-2 mb-2">
                        @foreach($archivos_guardados as $doc)
                            <div class="flex items-center gap-2 bg-white rounded shadow px-2 py-1">
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
        </form>
        <!-- Notificaciones -->
        <div
            x-data="{ show: false, message: '', type: '' }"
            x-on:notify.window="
                show = true;
                message = $event.detail.message;
                type = $event.detail.type;
                setTimeout(() => show = false, 2500);
            "
            x-show="show"
            x-transition
            class="fixed top-4 right-4 z-50"
        >
            <div :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'" class="text-white px-4 py-2 rounded shadow">
                <span x-text="message"></span>
            </div>
        </div>

        <!-- Formulario de creación de entidad -->
        @if($showEntidadForm)
            <div class="bg-white rounded-lg shadow-lg p-8 space-y-8 mt-4">
                <h2 class="text-xl font-bold text-[#003264] mb-4">Crear Entidad</h2>
                <form wire:submit.prevent="saveEntidad">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-[#003264] mb-1">Nombre de la entidad</label>
                            <input type="text" wire:model="nombreEntidad" class="form-input w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#0097ff] focus:outline-none" placeholder="Ingrese el nombre de la entidad" />
                            @error('nombreEntidad') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#003264] mb-1">Ubicación</label>
                            <input type="text" wire:model="ubicacion" class="form-input w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#0097ff] focus:outline-none" placeholder="Ingrese la ubicación" />
                            @error('ubicacion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#003264] mb-1">Contacto</label>
                            <input type="text" wire:model="contacto" class="form-input w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#0097ff] focus:outline-none" placeholder="Ingrese el contacto" />
                            @error('contacto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#003264] mb-1">Logo</label>
                            <div class="relative mb-4">
                                <input type="file" wire:model="logo" id="logo" class="hidden" />
                                <label for="logo" class="cursor-pointer inline-flex items-center justify-center w-full border border-neutral-300 rounded-lg px-4 py-2 bg-white text-sm text-[#003264] hover:bg-[#f0f8ff] hover:border-[#0097ff] transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#0097ff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Seleccionar archivo
                                </label>
                            </div>
                            <div wire:loading wire:target="logo" class="relative mb-4">
                                <div class="w-full h-2 bg-gray-200 rounded-lg overflow-hidden">
                                    <div class="h-full bg-[#0097ff] animate-pulse" style="width: 100%;"></div>
                                </div>
                                <span class="text-sm text-gray-500">Subiendo archivo...</span>
                            </div>
                            @if($logoPreview)
                                <div class="mb-4">
                                    <img src="{{ $logoPreview }}" alt="Logo actual" class="w-32 h-32 rounded-lg border border-gray-300 shadow-sm">
                                </div>
                            @endif
                            @error('logo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end gap-4 mt-8">
                        <button type="button" wire:click="closeEntidadForm" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 hover:text-gray-900 transition text-sm">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-[#0097ff] text-white rounded-lg hover:bg-[#007acc] transition text-sm">Guardar</button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>