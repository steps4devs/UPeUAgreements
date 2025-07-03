
<div class="bg-white rounded-lg shadow-lg p-8 space-y-8">
    <h2 class="text-xl font-bold text-[#003264] mb-4">{{ $entidadId ? 'Editar Entidad' : 'Crear Entidad' }}</h2>
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