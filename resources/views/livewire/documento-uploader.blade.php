<div>
    <input type="file" wire:model="archivo" class="mb-2" id="file-upload" x-ref="fileInput">
    <label for="file-upload" class="text-gray-500 text-sm cursor-pointer">Seleccionar archivos</label>
    <span class="text-xs text-gray-400 mt-2 block">Puedes subir archivos PDF, DOC, DOCX, imágenes.</span>
    @error('archivo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
</div>
