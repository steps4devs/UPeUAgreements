<x-layouts.app :title="__('Dashboard')">
    <div class="flex-1 flex flex-col gap-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <p class="text-neutral-500 dark:text-neutral-400">
                    Bienvenido, {{ Auth::user()->name }}. Aquí tienes un resumen de la actividad reciente.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <input type="text" placeholder="Buscar convenios, entidades, documentos..." class="input input-bordered w-64" />
                <button class="btn btn-neutral">Ayuda</button>
                <div class="flex items-center gap-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="avatar" class="w-8 h-8 rounded-full" />
                    <div>
                        <div class="font-semibold">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-neutral-500">{{ Auth::user()->rol }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Métricas -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-neutral-900 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700">
                <div class="text-sm text-neutral-500">Total Convenios</div>
                <div class="text-2xl font-bold">{{ $totalConvenios ?? 0 }}</div>
                <div class="text-xs text-green-600 mt-1">+12% desde el mes pasado</div>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700">
                <div class="text-sm text-neutral-500">Convenios Activos</div>
                <div class="text-2xl font-bold">{{ $conveniosActivos ?? 0 }}</div>
                <div class="text-xs text-neutral-500 mt-1">{{ $porcentajeActivos ?? 0 }}% del total</div>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700">
                <div class="text-sm text-neutral-500">Por Vencer</div>
                <div class="text-2xl font-bold">{{ $porVencer ?? 0 }}</div>
                <div class="text-xs text-orange-600 mt-1">Próximos 30 días</div>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700">
                <div class="text-sm text-neutral-500">Entidades Asociadas</div>
                <div class="text-2xl font-bold">{{ $entidadesAsociadas ?? 0 }}</div>
                <div class="text-xs text-green-600 mt-1">+3 este mes</div>
            </div>
        </div>

        <!-- Últimos Convenios y Distribución -->
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Últimos Convenios -->
            <div class="flex-1 bg-white dark:bg-neutral-900 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center justify-between mb-2">
                    <div class="font-semibold">Últimos Convenios</div>
                    <a href="{{ route('convenios-main') }}" class="text-blue-600 text-sm hover:underline">Ver todos</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-neutral-500">
                                <th class="py-2 px-2 text-left">NOMBRE DEL CONVENIO</th>
                                <th class="py-2 px-2 text-left">ENTIDAD</th>
                                <th class="py-2 px-2 text-left">FACULTAD</th>
                                <th class="py-2 px-2 text-left">FECHA INICIO</th>
                                <th class="py-2 px-2 text-left">FECHA FIN</th>
                                <th class="py-2 px-2 text-left">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimosConvenios ?? [] as $convenio)
                                <tr>
                                    <td class="py-2 px-2">{{ $convenio->nombre }}</td>
                                    <td class="py-2 px-2">{{ $convenio->entidad->nombre ?? '-' }}</td>
                                    <td class="py-2 px-2">{{ $convenio->facultad->nombreFacultad ?? 'Todas' }}</td>
                                    <td class="py-2 px-2">{{ $convenio->fecha_inicio->format('d/m/Y') }}</td>
                                    <td class="py-2 px-2">{{ $convenio->fecha_fin->format('d/m/Y') }}</td>
                                    <td class="py-2 px-2">
                                        @if($convenio->estado === 'Activo')
                                            <span class="text-green-600 font-semibold">Activo</span>
                                        @elseif($convenio->estado === 'Por vencer')
                                            <span class="text-orange-600 font-semibold">Por vencer</span>
                                        @else
                                            <span class="text-neutral-500 font-semibold">{{ $convenio->estado }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-neutral-400">No hay convenios recientes.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Distribución por Facultad -->
            <div class="w-full md:w-80 bg-white dark:bg-neutral-900 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700 flex flex-col gap-4">
                <div class="font-semibold mb-2">Distribución por Facultad</div>
                
            </div>
        </div>

        <!-- Acciones rápidas -->
        <div class="flex flex-col md:flex-row gap-4">
            @if(Auth::user()->rol === 'Administrador' || Auth::user()->rol === 'Sheridan')
                <a href="{{ route('convenios-main') }}?action=create" class="btn btn-primary flex-1">Nuevo Convenio</a>
            @endif
            <a href="{{ route('convenios-main') }}?action=export" class="btn btn-outline flex-1">Exportar</a>
            <a href="{{ route('configuracion-main') }}" class="btn btn-outline flex-1">Configuración</a>
        </div>
    </div>

    <!-- Chart.js para el gráfico de distribución por facultad -->
</x-layouts.app>
