<div>
    <div class="bg-[#f6f8ff] min-h-screen p-6">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold mb-1 text-[#003264]">Configuración del Sistema</h1>
            <p class="text-neutral-500 mb-6">Administre las opciones generales del sistema y configure sus preferencias</p>

            <!-- Mensajes de éxito y error -->
            @if($mensaje_exito)
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ $mensaje_exito }}
                    <button wire:click="limpiarMensajes" class="float-right text-green-500 hover:text-green-700">×</button>
                </div>
            @endif

            @if($mensaje_error)
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ $mensaje_error }}
                    <button wire:click="limpiarMensajes" class="float-right text-red-500 hover:text-red-700">×</button>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Gestión de Usuarios -->
                <div class="bg-white rounded-xl shadow p-5 flex flex-col border border-[#003264]">
                    <h2 class="font-semibold text-lg mb-2 flex items-center gap-2 text-[#003264]">
                        <span class="material-icons text-[#0097ff]">group</span>
                        Gestión de Usuarios
                    </h2>
                    <p class="text-sm text-neutral-500 mb-3">Administre los usuarios del sistema, sus roles y permisos</p>
                    <div class="flex flex-col gap-2 mb-4">
                        <button wire:click="gestionarUsuarios" class="w-full border border-[#0097ff] bg-white text-[#003264] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#0097ff] hover:text-white">Usuarios y Permisos</button>
                        <button wire:click="gestionarRoles" class="w-full border border-[#0097ff] bg-white text-[#003264] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#0097ff] hover:text-white">Roles del Sistema</button>
                        <button wire:click="invitarUsuarios" class="w-full border border-[#0097ff] bg-white text-[#003264] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#0097ff] hover:text-white">Invitar Nuevos Usuarios</button>
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xs font-semibold text-gray-400 mb-1 flex items-center justify-between">
                            Usuarios Recientes
                            <button wire:click="refrescarDatos" class="text-[#0097ff] hover:text-[#003264] transition">
                                <span class="material-icons text-sm">refresh</span>
                            </button>
                        </h3>
                        <ul class="space-y-2">
                            @forelse($usuarios_recientes as $usuario)
                                <li class="flex items-center gap-2">
                                    <span class="bg-gray-200 dark:bg-gray-700 rounded-full w-8 h-8 flex items-center justify-center font-bold text-gray-700 dark:text-gray-200">
                                        {{ $usuario['inicial'] }}
                                    </span>
                                    <div class="flex-1">
                                        <div class="text-sm font-medium">
                                            {{ $usuario['nombre'] }}
                                            @if($usuario['rol'])
                                                <span class="text-xs text-gray-400 ml-1">{{ $usuario['rol'] }}</span>
                                            @endif
                                        </div>
                                        @if($usuario['tiempo'])
                                            <div class="text-xs text-gray-400">{{ $usuario['tiempo'] }}</div>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="text-sm text-gray-500 text-center py-2">
                                    No hay usuarios registrados
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Configuración de Alertas -->
                <div class="bg-white rounded-xl shadow p-5 flex flex-col border border-[#0097ff]">
                    <h2 class="font-semibold text-lg mb-2 flex items-center gap-2 text-[#003264]">
                        <span class="material-icons text-[#ff8d00]">notifications</span>
                        Configuración de Alertas
                    </h2>
                    <p class="text-sm text-neutral-500 mb-3">Personalice las notificaciones y alertas del sistema</p>
                    <div class="flex flex-col gap-4 mb-4">
                        <!-- Alerta de Vencimiento -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0">
                            <span class="text-sm text-black dark:text-white">Alertas de vencimiento</span>
                            <label class="relative inline-flex items-center cursor-pointer mt-1 sm:mt-0">
                                <input type="checkbox" wire:model.live="alertas_vencimiento" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-offset-2 peer-focus:ring-[#003264] rounded-full peer-checked:bg-[#00b738] transition-all"></div>
                                <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-all peer-checked:translate-x-full"></div>
                            </label>
                        </div>

                        <!-- Alerta de Documentos -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0">
                            <span class="text-sm text-black dark:text-white">Alertas de documentos</span>
                            <label class="relative inline-flex items-center cursor-pointer mt-1 sm:mt-0">
                                <input type="checkbox" wire:model.live="alertas_documentos" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-offset-2 peer-focus:ring-[#003264] rounded-full peer-checked:bg-[#00b738] transition-all"></div>
                                <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-all peer-checked:translate-x-full"></div>
                            </label>
                        </div>

                        <!-- Alerta de Usuarios -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0">
                            <span class="text-sm text-black dark:text-white">Alertas de usuarios</span>
                            <label class="relative inline-flex items-center cursor-pointer mt-1 sm:mt-0">
                                <input type="checkbox" wire:model.live="alertas_usuarios" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-offset-2 peer-focus:ring-[#003264] rounded-full peer-checked:bg-[#00b738] transition-all"></div>
                                <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-all peer-checked:translate-x-full"></div>
                            </label>
                        </div>

                        <!-- Alerta de Cambios -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0">
                            <span class="text-sm text-black dark:text-white">Alertas de cambios</span>
                            <label class="relative inline-flex items-center cursor-pointer mt-1 sm:mt-0">
                                <input type="checkbox" wire:model.live="alertas_cambios" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-offset-2 peer-focus:ring-[#003264] rounded-full peer-checked:bg-[#00b738] transition-all"></div>
                                <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-all peer-checked:translate-x-full"></div>
                            </label>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="block text-xs text-gray-400 mb-1">Tiempo de anticipación</label>
                        <select wire:model.live="tiempo_anticipacion" class="w-full border bg-white text-black dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                            <option value="7">7 días antes</option>
                            <option value="15">15 días antes</option>
                            <option value="30">30 días antes</option>
                            <option value="60">60 días antes</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Frecuencia de recordatorios</label>
                        <select wire:model.live="frecuencia_recordatorios" class="w-full border bg-white text-black dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                            <option value="Diario">Diario</option>
                            <option value="Semanal">Semanal</option>
                            <option value="Mensual">Mensual</option>
                        </select>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="bg-white rounded-xl shadow p-5 flex flex-col border border-[#00b738]">
                    <h2 class="font-semibold text-lg mb-2 flex items-center gap-2 text-[#003264]">
                        <span class="material-icons text-[#00b738]">flash_on</span>
                        Acciones Rápidas
                    </h2>
                    <p class="text-sm text-neutral-500 mb-3">Acceda rápidamente a las funciones más utilizadas</p>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <button wire:click="irDashboard" class="flex items-center justify-center h-32 w-full border-2 border-[#003264] bg-white text-[#003264] rounded-2xl text-2xl font-normal text-center transition hover:bg-[#003264] hover:text-white">Dashboard</button>
                        <button wire:click="irConvenios" class="flex items-center justify-center h-32 w-full border-2 border-[#0097ff] bg-white text-[#0097ff] rounded-2xl text-2xl font-normal text-center transition hover:bg-[#0097ff] hover:text-white">Convenios</button>
                        <button wire:click="irEntidades" class="flex items-center justify-center h-32 w-full border-2 border-[#00b738] bg-white text-[#00b738] rounded-2xl text-2xl font-normal text-center transition hover:bg-[#00b738] hover:text-white">Entidades</button>
                        <button wire:click="irReportes" class="flex items-center justify-center h-32 w-full border-2 border-[#ff8d00] bg-white text-[#ff8d00] rounded-2xl text-2xl font-normal text-center transition hover:bg-[#ff8d00] hover:text-white">Reportes</button>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 mb-1">Exportar Datos</h3>
                        <div class="flex flex-col gap-2">
                            <button wire:click="exportarExcel" class="w-full border border-[#0097ff] bg-white text-[#0097ff] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#0097ff] hover:text-white">Exportar a Excel</button>
                            <button wire:click="exportarPDF" class="w-full border border-[#ff8d00] bg-white text-[#ff8d00] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#ff8d00] hover:text-white">Exportar a PDF</button>
                            <button wire:click="exportarCSV" class="w-full border border-[#00b738] bg-white text-[#00b738] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#00b738] hover:text-white">Exportar a CSV</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Datos del Administrador CON DROPDOWN DE CARRERAS (SIMPLIFICADO) -->
                <div class="bg-white rounded-xl shadow p-5 flex flex-col border border-[#944dd5]">
                    <h2 class="font-semibold text-lg mb-2 flex items-center gap-2 text-[#003264]">
                        <span class="material-icons text-[#944dd5]">person</span>
                        Datos del Usuario
                    </h2>
                    <div class="mb-3">
                        <div class="font-bold text-base text-black dark:text-white">{{ $admin_nombre ?? 'Usuario' }}</div>
                        <div class="text-xs text-neutral-500">{{ $admin_rol ?? 'Sin rol asignado' }}</div>
                        <div class="text-xs text-neutral-500">{{ $admin_email ?? 'Sin email' }}</div>
                        @if($admin_carrera && $admin_carrera !== 'Sin asignar')
                            <div class="text-xs text-red-600">Carrera: {{ $admin_carrera }}</div>
                        @endif
                    </div>
                    <form wire:submit="actualizarPerfil" class="flex flex-col gap-2">
                        <label class="text-xs text-gray-400">Nombre completo</label>
                        <input type="text" wire:model="admin_nombre" class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition" />
                        @error('admin_nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                        <label class="text-xs text-gray-400">Correo electrónico</label>
                        <input type="email" wire:model="admin_email" class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition" />
                        @error('admin_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                        <label class="text-xs text-gray-400">Nueva contraseña (opcional)</label>
                        <input type="password" wire:model="admin_password" class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition" placeholder="Dejar en blanco para mantener actual" />
                        @error('admin_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                        <label class="text-xs text-gray-400">Rol</label>
                        <select wire:model="admin_rol" class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                            <option value="">Seleccionar rol</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Coordinador">Coordinador</option>
                            <option value="Secretaria">Secretaria</option>
                        </select>
                        @error('admin_rol') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                        <!-- Dropdown de Carreras (SIMPLIFICADO) -->
                        <label class="text-xs text-gray-400">Carrera</label>
                        <select wire:model.live="admin_carrera_id" class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                            <option value="">Seleccionar carrera</option>
                            @if(!empty($carreras_disponibles))
                                @foreach($carreras_disponibles as $carrera)
                                    <option value="{{ $carrera['id'] }}">{{ $carrera['nombre'] }}</option>
                                @endforeach
                            @else
                                <option value="" disabled>No hay carreras disponibles</option>
                            @endif
                        </select>
                        @error('admin_carrera_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                        <!-- Debug información (opcional - remover en producción) -->
                        @if(config('app.debug'))
                            <div class="text-xs text-gray-500 bg-gray-50 p-2 rounded">
                                <strong>Debug:</strong> {{ count($carreras_disponibles) }} carreras cargadas
                                @if($admin_carrera_id)
                                    | ID seleccionado: {{ $admin_carrera_id }}
                                @endif
                                <button type="button" wire:click="debugCarreras" class="ml-2 text-blue-500 underline">Ver logs</button>
                            </div>
                        @endif

                        <!-- Mostrar carrera seleccionada actualmente -->
                        @if($admin_carrera && $admin_carrera !== 'Sin asignar')
                            <div class="text-xs text-green-600 bg-green-50 p-2 rounded-lg">
                                <strong>Carrera actual:</strong> {{ $admin_carrera }}
                            </div>
                        @endif

                        <button type="submit" class="w-full border border-[#0097ff] bg-white text-[#0097ff] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#0097ff] hover:text-white mt-2">
                            <span wire:loading.remove wire:target="actualizarPerfil">Actualizar Perfil</span>
                            <span wire:loading wire:target="actualizarPerfil">
                                <span class="inline-block animate-spin mr-2">⟳</span>
                                Actualizando...
                            </span>
                        </button>
                    </form>
                </div>

                <!-- Información del Sistema -->
                <div class="bg-white rounded-xl shadow p-5 flex flex-col border border-[#ff8d00]">
                    <h2 class="font-semibold text-lg mb-2 flex items-center gap-2 text-[#003264]">
                        <span class="material-icons text-[#ff8d00]">info</span>
                        Información del Sistema
                    </h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Carreras disponibles:</span>
                            <span class="text-sm font-semibold text-[#003264]">{{ count($carreras_disponibles) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Usuarios registrados:</span>
                            <span class="text-sm font-semibold text-[#003264]">{{ count($usuarios_recientes) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Versión del sistema:</span>
                            <span class="text-sm font-semibold text-[#003264]">1.0.0</span>
                        </div>
                        <div class="border-t pt-3 mt-3">
                            <button wire:click="refrescarDatos" class="w-full border border-[#00b738] bg-white text-[#00b738] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#00b738] hover:text-white">
                                <span wire:loading.remove wire:target="refrescarDatos">Refrescar Datos</span>
                                <span wire:loading wire:target="refrescarDatos">
                                    <span class="inline-block animate-spin mr-2">⟳</span>
                                    Refrescando...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas Rápidas -->
                <div class="bg-white rounded-xl shadow p-5 flex flex-col border border-[#944dd5]">
                    <h2 class="font-semibold text-lg mb-2 flex items-center gap-2 text-[#003264]">
                        <span class="material-icons text-[#944dd5]">analytics</span>
                        Estadísticas
                    </h2>
                    <div class="space-y-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-[#0097ff]">{{ count($usuarios_recientes) }}</div>
                            <div class="text-xs text-gray-500">Usuarios Activos</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-[#00b738]">{{ count($carreras_disponibles) }}</div>
                            <div class="text-xs text-gray-500">Carreras Disponibles</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-[#ff8d00]">
                                {{ $alertas_vencimiento && $alertas_documentos && $alertas_usuarios && $alertas_cambios ? '100%' : '75%' }}
                            </div>
                            <div class="text-xs text-gray-500">Alertas Activas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para auto-ocultar mensajes -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('mostrar-mensaje', () => {
                setTimeout(() => {
                    @this.limpiarMensajes();
                }, 5000);
            });

            Livewire.on('mostrar-error', () => {
                setTimeout(() => {
                    @this.limpiarMensajes();
                }, 8000);
            });
        });
    </script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</div>