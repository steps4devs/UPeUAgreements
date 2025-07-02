<div class="w-full p-2 sm:p-4 md:p-6 bg-white rounded-lg shadow">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
        <h2 class="text-xl sm:text-2xl font-bold">Gestión de Entidades</h2>


        <a href="{{ route('entidades.create') }}"
                class="w-full md:w-44 h-9 flex items-center justify-center border border-[#0097ff] text-white bg-[#0097ff] hover:bg-white hover:text-black rounded-full font-medium transition-all duration-200 ease-in-out transform hover:scale-105 text-sm gap-2">
                <x-heroicon-o-plus class="w-6 h-6"/>
                Nueva entidad
            </a>
    </div>

    <div class="flex flex-col sm:flex-row mb-4 gap-2">

        <flux:input wire:model.live="search" type="text" placeholder="Buscar entidad..." icon:trailing="loading"/>
        <flux:select wire:model.live="perPage" class="border rounded px-2 py-2 w-24 text-sm w-min">
            <flux:select.option value="5">5</flux:select.option>
            <flux:select.option value="10">10</flux:select.option>
            <flux:select.option value="25">25</flux:select.option>
        </flux:select>
    </div>

    <div class="hidden md:grid grid-cols-5 gap-2 bg-gray-100 rounded-t-lg px-2 sm:px-4 py-2 font-semibold text-xs sm:text-sm">
        <div class="truncate">Logo</div>
        <div class="truncate">Nombre</div>
        <div class="truncate">Ubicación</div>
        <div class="truncate">Contacto</div>
        <div class="truncate">Acciones</div>
    </div>

    <div class="divide-y">
        @forelse($entidades as $entidad)
            <div wire:key="entidad-{{ $entidad->id }}" class="grid grid-cols-1 md:grid-cols-5 gap-2 items-center px-2 sm:px-4 py-3 hover:bg-gray-50 text-xs sm:text-sm">
                <div class="flex items-center justify-center">
                    @if($entidad->logo)
                        <img src="{{ asset('storage/' . $entidad->logo) }}" alt="Logo" class="w-10 h-10 rounded">
                    @else
                        <span class="text-gray-500">Sin logo</span>
                    @endif
                </div>
                <div class="break-words whitespace-normal min-w-0" title="{{ $entidad->nombreEntidad }}">
                    <span class="md:hidden font-semibold text-gray-500">Nombre: </span>
                    <span class="font-medium">{{ $entidad->nombreEntidad }}</span>
                </div>
                <div class="break-words whitespace-normal min-w-0">
                    <span class="md:hidden font-semibold text-gray-500">Ubicación: </span>
                    <span>{{ $entidad->ubicacion }}</span>
                </div>
                <div class="break-words whitespace-normal min-w-0">
                    <span class="md:hidden font-semibold text-gray-500">Contacto: </span>
                    <span>{{ $entidad->contacto }}</span>
                </div>
                <div class="flex flex-wrap gap-1 justify-start md:justify-center mt-2 md:mt-0">
                    <a href="{{ route('entidades.edit', $entidad->id) }}" class="text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-100 transition" title="Editar">
                        <x-heroicon-o-pencil-square class="w-7 h-7"/>
                    </a>
                    <button wire:click="delete({{ $entidad->id }})" class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-100 transition" title="Eliminar">
                        <x-heroicon-o-trash class="w-7 h-7"/>
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-4 text-gray-500">No hay entidades registradas.</div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $entidades->links() }}
    </div>
</div>
