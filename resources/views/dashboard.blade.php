<div class="min-h-screen w-full bg-[#EEF1F6]">
    <x-layouts.app :title="('Dashboard')">
        <!-- Barra superior -->
        <div class="flex items-center justify-between w-full px-6 py-0.2">
            <div class="flex-1 flex justify-center">
                <div class="relative w-[400px]">
                    <input
                        type="text"
                        placeholder="Buscar convenios, entidades, documentos..."
                        class="w-full pl-4 pr-10 py-1.5 rounded-full border bg-white border-neutral-300 focus:outline-none focus:ring-2 focus:ring-[#003264] text-sm transition-all duration-200 ease-in-out transform focus:scale-105"
                    />
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="border border-[#003264] rounded-full px-5 py-1 text-sm text-[#003264] bg-white hover:bg-[#003264] hover:text-white hover:border-[#003264] transition-all duration-200 ease-in-out transform hover:scale-105">Ayuda</button>
                <div class="flex items-center gap-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="avatar" class="w-8 h-8 rounded-full" />
                    <div>
                        <div class="font-semibold">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-neutral-500">{{ Auth::user()->rol }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 flex flex-col gap-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-[#003264]">Dashboard</h1>
                    <p class="text-neutral-500 dark:text-neutral-400">
                        Bienvenido, {{ Auth::user()->name }}. Aquí tienes un resumen de la actividad reciente.
                    </p>
                </div>
            </div>

            <!-- Métricas -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
               <div class="bg-[#003264] border border-[#003264] rounded-xl p-4 shadow-lg hover:shadow-2xl transition-shadow duration-300 ease-in-out transform hover:scale-101 text-sm">
                    <div class="text-sm text-white font-semibold">Total Convenios</div>
                    <div class="text-2xl font-bold text-white">{{ $totalConvenios ?? 0 }}</div>
                    <div class="text-xs text-[#0097ff] mt-1">+12% desde el mes pasado</div>
                </div>

                <div class="bg-white border border-white rounded-xl p-4 shadow-lg hover:shadow-2xl transition-shadow duration-300 ease-in-out transform hover:scale-101 text-sm">
                    <div class="text-sm text-[#003264] font-semibold">Convenios Activos</div>
                    <div class="text-2xl font-bold text-[#003264]">{{ $conveniosActivos ?? 0 }}</div>
                    <div class="text-xs text-[#00b738] mt-1">{{ $porcentajeActivos ?? 0 }}% del total</div>
                </div>
                <div class="bg-[#fff7e6] border border-[#ff8d00] rounded-xl p-4 shadow-lg hover:shadow-2xl transition-shadow duration-300 ease-in-out transform hover:scale-101 text-sm">
                    <div class="text-sm text-[#003264] font-semibold">Por Vencer</div>
                    <div class="text-2xl font-bold text-[#003264]">{{ $porVencer ?? 0 }}</div>
                    <div class="text-xs text-[#ff8d00] mt-1">Próximos 30 días</div>
                </div>
                <div class="bg-[#f7ecff] border border-[#944dd5] rounded-xl p-4 shadow-lg hover:shadow-2xl transition-shadow duration-300 ease-in-out transform hover:scale-101 text-sm">
                    <div class="text-sm text-[#003264] font-semibold">Entidades Asociadas</div>
                    <div class="text-2xl font-bold text-[#003264]">{{ $entidadesAsociadas ?? 0 }}</div>
                    <div class="text-xs text-[#944dd5] mt-1">+3 este mes</div>
                </div>
            </div>

            <!-- Últimos Convenios y Distribución -->
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Últimos Convenios -->
                <div class="flex-1 bg-white dark:bg-neutral-900 rounded-xl p-4 border border-[#003264] dark:border-[#003264] shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
                    <div class="flex items-center justify-between mb-4">
                        <div class="font-semibold text-[#003264] text-lg">Últimos Convenios</div>
                        <a href="{{ route('convenios-main') }}"
                           class="px-4 py-2 bg-[#0097ff] text-white rounded-full font-medium border border-[#0097ff] hover:bg-white hover:text-black hover:border-[#0097ff] transition-all duration-200 ease-in-out transform hover:scale-101 text-sm">
                            Ver todos
                        </a>
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
                                    <tr class="hover:bg-neutral-100">
                                        <td class="py-2 px-2">{{ $convenio->nombreConvenio }}</td>
                                        <td class="py-2 px-2">{{ $convenio->entidad->nombreEntidad ?? '-' }}</td>
                                        <td class="py-2 px-2">{{ $convenio->facultad->nombreFacultad ?? 'Todas' }}</td>
                                        <td class="py-2 px-2">{{ $convenio->fecha_inicio->format('d/m/Y') }}</td>
                                        <td class="py-2 px-2">{{ $convenio->fecha_fin->format('d/m/Y') }}</td>
                                        <td class="py-2 px-2">
                                            @if($convenio->estado === 'Vigente')
                                                <span class="text-green-600 font-semibold">Vigente</span>
                                            @elseif($convenio->estado === 'Por vencer')
                                                <span class="text-orange-600 font-semibold">Por vencer</span>
                                            @else
                                                <span class="text-red-600 font-semibold">Vencido</span>
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
                <!-- Distribución por Facultad y Acciones Rápidas -->
                <div class="w-full md:w-80 flex flex-col gap-4">
                    <!-- Distribución por Facultad -->
                    @if(!in_array(Auth::user()->rol, ['Secretaria', 'Coordinador']))
                        <div class="bg-white dark:bg-neutral-900 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700 flex flex-col gap-4 shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
                            <div class="font-semibold mb-2 text-[#003264]">Distribución por Facultad</div>
                            <!-- Aquí agregamos el canvas para el gráfico -->
                            <div class="facultadChart">
                                <canvas id="facultadChart" height="220"></canvas>
                            </div>
                        </div>
                    @endif
                    <!-- Acciones Rápidas -->
                    <div class="bg-white dark:bg-neutral-900 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700 flex flex-col gap-3 shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
                        <div class="font-semibold mb-2 text-[#003264]">Acciones Rápidas</div>
                        @if(Auth::user()->rol === 'Administrador' || Auth::user()->rol === 'Sheridan')
                            <!-- Botón Nuevo Convenio -->
                            <a href="{{ route('convenios.create') }}"
                                class="w-full md:w-full h-9 flex items-center justify-center border border-[#0097ff] text-white bg-[#0097ff] hover:bg-white hover:text-black rounded-full font-medium transition-all duration-200 ease-in-out transform hover:scale-101 text-sm gap-2">
                                <x-heroicon-o-plus class="w-6 h-6"/>
                                Nuevo Convenio
                            </a>
                        @endif
                        <!-- Botón Exportar -->
                        <a href="{{ route('convenios-main') }}?action=export"
                           class="w-full h-9 flex items-center justify-center border border-black text-white bg-black hover:bg-white hover:text-black hover:border-black rounded-full font-medium transition-all duration-200 ease-in-out transform hover:scale-101 text-sm">
                            Exportar
                        </a>

                        <!-- Botón Configuración -->
                        <a href="{{ route('configuracion-main') }}"
                           class="w-full h-9 flex items-center justify-center border border-[#003264] text-[#003264] bg-white hover:bg-[#003264] hover:text-white hover:border-[#003264] rounded-full font-medium transition-all duration-200 ease-in-out transform hover:scale-101 text-sm">
                            Configuración
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if(!in_array(Auth::user()->rol, ['Secretaria', 'Coordinador']))
            @php
                $labels = $facultades->pluck('facultad')->toArray();
                $data = $facultades->pluck('total')->toArray();
            @endphp
            <style>
                .facultadChart canvas {
                    width: 300px !important;
                    height: 300px !important;
                    max-width: none !important;
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const ctx = document.getElementById('facultadChart').getContext('2d');
                    const facultadChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: @json($labels),
                            datasets: [{
                                data: @json($data),
                                backgroundColor: [
                                    '#4CAF50', // Ingeniería
                                    '#FF9800', // Ciencias Empresariales
                                    '#2196F3', // Ciencias de la Salud
                                    '#9C27B0', // Educación
                                    '#607D8B'  // Otros
                                ],
                                hoverOffset: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        color: '#003264',
                                        font: {
                                            size: 14
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (tooltipItem) {
                                            const value = tooltipItem.raw;
                                            return `${tooltipItem.label}: ${value}`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        @endif
    </x-layouts.app>
</div>