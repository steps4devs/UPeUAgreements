<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración del Sistema</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Agrega aquí tus enlaces a CSS adicionales -->
</head>
<body>
    <div class="bg-[#f6f8ff] min-h-screen p-6">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold mb-1 text-[#003264]">Configuración del Sistema</h1>
            <p class="text-neutral-500 mb-6">Administre las opciones generales del sistema y configure sus preferencias</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Gestión de Usuarios -->
                <div class="bg-white rounded-xl shadow p-5 flex flex-col border border-[#003264]">
                    <h2 class="font-semibold text-lg mb-2 flex items-center gap-2 text-[#003264]">
                        <span class="material-icons text-[#0097ff]">group</span>
                        Gestión de Usuarios
                    </h2>
                    <p class="text-sm text-neutral-500 mb-3">Administre los usuarios del sistema, sus roles y permisos</p>
                    <div class="flex flex-col gap-2 mb-4">
                        <button class="w-full border border-[#0097ff] bg-white text-[#003264] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#0097ff] hover:text-white">Usuarios y Permisos</button>
                        <button class="w-full border border-[#0097ff] bg-white text-[#003264] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#0097ff] hover:text-white">Roles del Sistema</button>
                        <button class="w-full border border-[#0097ff] bg-white text-[#003264] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#0097ff] hover:text-white">Invitar Nuevos Usuarios</button>
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xs font-semibold text-gray-400 mb-1">Usuarios Recientes</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2">
                        <span class="bg-gray-200 dark:bg-gray-700 rounded-full w-8 h-8 flex items-center justify-center font-bold text-gray-700 dark:text-gray-200">M</span>
                                <div class="flex-1">
                                    <div class="text-sm font-medium">María Rodríguez <span class="text-xs text-gray-400 ml-1">Coordinadora</span></div>
                                    <div class="text-xs text-gray-400">Hace 2 días</div>
                                </div>
                            </li>
                            <li class="flex items-center gap-2">
                        <span class="bg-gray-200 dark:bg-gray-700 rounded-full w-8 h-8 flex items-center justify-center font-bold text-gray-700 dark:text-gray-200">J</span>
                                <div class="flex-1">
                                    <div class="text-sm font-medium">Juan Pérez <span class="text-xs text-gray-400 ml-1">Gestor</span></div>
                                    <div class="text-xs text-gray-400">Hace 3 días</div>
                                </div>
                            </li>
                            <li class="flex items-center gap-2">
                        <span class="bg-gray-200 dark:bg-gray-700 rounded-full w-8 h-8 flex items-center justify-center font-bold text-gray-700 dark:text-gray-200">A</span>
                                <div class="flex-1">
                                    <div class="text-sm font-medium">Ana Gómez <span class="text-xs text-gray-400 ml-1">Administradora</span></div>
                                    <div class="text-xs text-gray-400">Hace 5 días</div>
                                </div>
                            </li>
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
                        @foreach(['Alertas de vencimiento', 'Alertas de documentos', 'Alertas de usuarios', 'Alertas de cambios'] as $alerta)
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0">
                            <span class="text-sm text-black dark:text-white">{{ $alerta }}</span>
                            <label class="relative inline-flex items-center cursor-pointer mt-1 sm:mt-0">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-[#0097ff] peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-offset-2 peer-focus:ring-[#003264] rounded-full peer-checked:bg-[#00b738] transition-all"></div>
                                <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-all peer-checked:translate-x-full"></div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="mb-2">
                        <label class="block text-xs text-gray-400 mb-1">Tiempo de anticipación</label>
                        <select class="w-full border bg-white text-black dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                            <option>30 días antes</option>
                            <option>15 días antes</option>
                            <option>7 días antes</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Frecuencia de recordatorios</label>
                        <select class="w-full border bg-white text-black dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                            <option>Diario</option>
                            <option>Semanal</option>
                            <option>Mensual</option>
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
                        <button type="button" onclick="window.location.href='{{ route('dashboard') }}'" class="flex items-center justify-center h-32 w-full border-2 border-[#003264] bg-white text-[#003264] rounded-2xl text-2xl font-normal text-center transition hover:bg-[#003264] hover:text-white">Dashboard</button>
                        <button type="button" onclick="window.location.href='{{ route('convenios-main') }}'" class="flex items-center justify-center h-32 w-full border-2 border-[#0097ff] bg-white text-[#0097ff] rounded-2xl text-2xl font-normal text-center transition hover:bg-[#0097ff] hover:text-white">Convenios</button>
                        <button type="button" onclick="window.location.href='{{ route('entidades-main') }}'" class="flex items-center justify-center h-32 w-full border-2 border-[#00b738] bg-white text-[#00b738] rounded-2xl text-2xl font-normal text-center transition hover:bg-[#00b738] hover:text-white">Entidades</button>
                        <button type="button" onclick="window.location.href='{{ route('reportes-main') }}'" class="flex items-center justify-center h-32 w-full border-2 border-[#ff8d00] bg-white text-[#ff8d00] rounded-2xl text-2xl font-normal text-center transition hover:bg-[#ff8d00] hover:text-white">Reportes</button>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 mb-1">Exportar Datos</h3>
                        <div class="flex flex-col gap-2">
                            <button class="w-full border border-[#0097ff] bg-white text-[#0097ff] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#0097ff] hover:text-white">Exportar a Excel</button>
                            <button class="w-full border border-[#ff8d00] bg-white text-[#ff8d00] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#ff8d00] hover:text-white">Exportar a PDF</button>
                            <button class="w-full border border-[#00b738] bg-white text-[#00b738] rounded-full py-2 text-base font-medium text-center transition hover:bg-[#00b738] hover:text-white">Exportar a CSV</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Datos del Administrador -->
                <div class="bg-white rounded-xl shadow p-5 flex flex-col border border-[#944dd5]">
                    <h2 class="font-semibold text-lg mb-2 flex items-center gap-2 text-[#003264]">
                        <span class="material-icons text-[#944dd5]">person</span>
                        Datos del Administrador
                    </h2>
                    <div class="mb-3">
                        <div class="font-bold text-base text-black dark:text-white">Carlos Mendoza</div>
                        <div class="text-xs text-neutral-500">Administrador del Sistema</div>
                        <div class="text-xs text-neutral-500">carlos.mendoza@universidad.edu.co</div>
                    </div>
                    <form class="flex flex-col gap-2">
                        <label class="text-xs text-gray-400">Nombre completo</label>
                        <input type="text" class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition" value="Carlos Mendoza" />
                        <label class="text-xs text-gray-400">Correo electrónico</label>
                        <input type="email" class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition" value="carlos.mendoza@universidad.edu.co" />
                        <label class="text-xs text-gray-400">Teléfono</label>
                        <input type="text" class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition" value="+57 300 123 4567" />
                        <label class="text-xs text-gray-400">Departamento</label>
                        <input type="text" class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition" value="Dirección de Convenios" />
                        <button class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-full py-2 text-base font-medium text-center transition mt-2">Actualizar Perfil</button>
                    </form>
                </div>
                <!-- Configuración General -->
                <div class="bg-white rounded-xl shadow p-5 flex flex-col border border-[#003264]">
                    <h2 class="font-semibold text-lg mb-2 flex items-center gap-2 text-[#003264]">
                        <span class="material-icons text-[#0097ff]">settings</span>
                        Configuración General
                    </h2>
                    <form class="flex flex-col gap-2">
                        <label class="text-xs text-gray-400">Idioma del sistema</label>
                        <select class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                            <option>Español</option>
                            <option>Inglés</option>
                        </select>
                        <label class="text-xs text-gray-400">Zona horaria</label>
                        <select class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                            <option>América/Bogotá (UTC-5)</option>
                            <option>América/Lima (UTC-5)</option>
                            <option>Europa/Madrid (UTC+1)</option>
                        </select>
                        <label class="text-xs text-gray-400">Formato de fecha</label>
                        <select class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                            <option>DD/MM/AAAA</option>
                            <option>MM/DD/AAAA</option>
                        </select>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-xs text-gray-400">Modo oscuro</span>
                            <input type="checkbox" class="toggle toggle-sm" checked />
                            <span class="text-xs text-gray-500">Cambiar a tema oscuro</span>
                        </div>
                        <div class="mt-2">
                            <div class="text-xs font-semibold text-gray-400 dark:text-gray-400 text-gray-600 mb-1">Opciones de visualización</div>
                            <div class="flex flex-col gap-1">
                                <!-- Opción 1 -->
                                <label class="flex items-center gap-2 text-base select-none relative cursor-pointer">
                                    <input type="checkbox" class="absolute w-7 h-7 opacity-0 cursor-pointer peer" checked wire:model="mostrar_estadisticas">
                                    <span class="w-7 h-7 flex items-center justify-center border-2 border-[#1ccfcf] rounded-lg bg-white dark:bg-gray-900 peer-checked:border-[#1ccfcf] transition">
                                        <svg class="w-5 h-5 text-[#1ccfcf] opacity-0 peer-checked:opacity-100 transition" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="pl-2 text-black dark:text-white">Mostrar estadísticas en Dashboard</span>
                                </label>
                                <!-- Opción 2 -->
                                <label class="flex items-center gap-2 text-base select-none relative cursor-pointer">
                                    <input type="checkbox" class="absolute w-7 h-7 opacity-0 cursor-pointer peer" wire:model="mostrar_convenios">
                                    <span class="w-7 h-7 flex items-center justify-center border-2 border-[#1ccfcf] rounded-lg bg-white dark:bg-gray-900 peer-checked:border-[#1ccfcf] transition">
                                        <svg class="w-5 h-5 text-[#1ccfcf] opacity-0 peer-checked:opacity-100 transition" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="pl-2 text-black dark:text-white">Mostrar convenios próximos a vencer</span>
                                </label>
                                <!-- Opción 3 -->
                                <label class="flex items-center gap-2 text-base select-none relative cursor-pointer">
                                    <input type="checkbox" class="absolute w-7 h-7 opacity-0 cursor-pointer peer" wire:model="mostrar_actividad">
                                    <span class="w-7 h-7 flex items-center justify-center border-2 border-[#1ccfcf] rounded-lg bg-white dark:bg-gray-900 peer-checked:border-[#1ccfcf] transition">
                                        <svg class="w-5 h-5 text-[#1ccfcf] opacity-0 peer-checked:opacity-100 transition" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="pl-2 text-black dark:text-white">Mostrar actividad reciente</span>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Seguridad -->
                <div class="bg-white rounded-xl shadow p-5 flex flex-col border border-[#ff8d00]">
                    <h2 class="font-semibold text-lg mb-2 flex items-center gap-2 text-[#003264]">
                        <span class="material-icons text-[#ff8d00]">security</span>
                        Seguridad
                    </h2>
                    <form class="flex flex-col gap-2">
                        <label class="text-xs text-gray-400">Contraseña actual</label>
                        <input type="password" class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition" />
                        <label class="text-xs text-gray-400">Nueva contraseña</label>
                        <input type="password" class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition" />
                        <label class="text-xs text-gray-400">Confirmar nueva contraseña</label>
                        <input type="password" class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-black dark:text-white rounded-2xl py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-indigo-200 transition" />
                        <button class="w-full border border-[#ff8d00] bg-[#ff8d00] text-white rounded-full py-2 text-base font-medium text-center transition mt-2 hover:bg-[#003264] hover:border-[#003264]">Cambiar Contraseña</button>
                    </form>
                    <div class="mt-4">
                        <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Opciones de seguridad</div>
                            <div class="flex flex-col gap-2">
                                <label class="flex items-center gap-2 text-xs text-black dark:text-white">
                                    <input type="checkbox" class="accent-blue-600" />
                                    Autenticación de dos factores
                                </label>
                                <label class="flex items-center gap-2 text-xs text-black dark:text-white">
                                    <input type="checkbox" class="accent-blue-600 dark:accent-indigo-400" />
                                    Cierre de sesión automático
                                    <span class="text-gray-500 dark:text-gray-400">Después de 30 minutos de inactividad</span>
                                </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
