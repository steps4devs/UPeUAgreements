<div class="max-w-5xl mx-auto py-6">
    <form wire:submit.prevent="save" class="bg-white rounded-lg shadow-lg p-8 space-y-8">
        <h2 class="text-2xl font-bold text-[#003264] mb-4">{{ $entidadId ? 'Editar Entidad' : 'Crear Entidad' }}</h2>
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
                <input type="file" wire:model="logo" class="form-input w-full border border-neutral-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#0097ff] focus:outline-none" />
                @error('logo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex justify-end gap-4 mt-8">
            <button type="button" onclick="window.history.back()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 hover:text-gray-900 transition text-sm">Cancelar</button>
            <button type="submit" class="px-4 py-2 bg-[#0097ff] text-white rounded-lg hover:bg-[#007acc] transition text-sm">Guardar</button>
        </div>
    </form>
</div>
