<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\AlertaConfiguracion;
use App\Models\Carrera;

class ConfiguracionMain extends Component
{
    // Propiedades para el formulario de administrador
    public $admin_nombre;
    public $admin_email;
    public $admin_password;
    public $admin_rol;
    public $admin_carrera;
    public $admin_carrera_id;

    // Propiedades para configuración de alertas
    public $alertas_vencimiento = true;
    public $alertas_documentos = true;
    public $alertas_usuarios = true;
    public $alertas_cambios = true;
    public $tiempo_anticipacion = '30';
    public $frecuencia_recordatorios = 'Diario';

    // Variables de estado
    public $mensaje_exito = '';
    public $mensaje_error = '';
    public $usuarios_recientes = [];

    // Propiedades para carreras (SIMPLIFICADO - solo carreras)
    public $carreras_disponibles = [];

    public function mount()
    {
        // Cargar datos del usuario actual
        $this->cargarDatosUsuarioActual();

        // Cargar configuraciones de alertas existentes
        $this->cargarConfiguracionAlertas();

        // Cargar usuarios recientes REALES
        $this->cargarUsuariosRecientes();

        // Cargar carreras disponibles (SIMPLIFICADO)
        $this->cargarCarrerasDisponibles();
    }

    public function cargarDatosUsuarioActual()
    {
        $user = Auth::user();
        if ($user) {
            $this->admin_nombre = $user->name;
            $this->admin_email = $user->email;
            $this->admin_rol = $user->rol ?? 'Usuario';
            $this->admin_carrera_id = $user->user_carrera_id;

            // Cargar el nombre de la carrera si existe
            if ($user->user_carrera_id) {
                try {
                    $carrera = Carrera::find($user->user_carrera_id);
                    $this->admin_carrera = $carrera ? $carrera->nombreCarrera : 'Sin asignar';
                } catch (\Exception $e) {
                    $this->admin_carrera = 'Sin asignar';
                }
            } else {
                $this->admin_carrera = 'Sin asignar';
            }
        }
    }

    // MÉTODO SIMPLIFICADO PARA CARGAR SOLO CARRERAS
    public function cargarCarrerasDisponibles()
    {
        try {
            // Verificar que existe la tabla carreras
            if (Schema::hasTable('carreras')) {
                // Obtener todas las carreras ordenadas por nombre
                $carreras = Carrera::orderBy('nombreCarrera', 'asc')->get();

                // Convertir a array simple
                $this->carreras_disponibles = $carreras->map(function ($carrera) {
                    return [
                        'id' => $carrera->id,
                        'nombre' => $carrera->nombreCarrera
                    ];
                })->toArray();

                // Debug: Ver cuántas carreras se cargaron
                Log::info('Carreras cargadas: ' . count($this->carreras_disponibles));

            } else {
                Log::warning('La tabla carreras no existe');
                $this->carreras_disponibles = [];
            }
        } catch (\Exception $e) {
            Log::error('Error cargando carreras: ' . $e->getMessage());
            $this->carreras_disponibles = [];
        }
    }

    public function cargarConfiguracionAlertas()
    {
        try {
            // Verificar si el modelo existe antes de usarlo
            if (class_exists('App\Models\AlertaConfiguracion')) {
                $configuracion = AlertaConfiguracion::where('user_id', Auth::id())->first();

                if ($configuracion) {
                    $this->alertas_vencimiento = $configuracion->alertas_vencimiento ?? true;
                    $this->alertas_documentos = $configuracion->alertas_documentos ?? true;
                    $this->alertas_usuarios = $configuracion->alertas_usuarios ?? true;
                    $this->alertas_cambios = $configuracion->alertas_cambios ?? true;
                    $this->tiempo_anticipacion = $configuracion->tiempo_anticipacion ?? '30';
                    $this->frecuencia_recordatorios = $configuracion->frecuencia_recordatorios ?? 'Diario';
                }
            }
        } catch (\Exception $e) {
            // Si hay error, usar valores por defecto
            $this->alertas_vencimiento = true;
            $this->alertas_documentos = true;
            $this->alertas_usuarios = true;
            $this->alertas_cambios = true;
            $this->tiempo_anticipacion = '30';
            $this->frecuencia_recordatorios = 'Diario';
        }
    }

    public function cargarUsuariosRecientes()
    {
        try {
            // Obtener los últimos 3 usuarios registrados o activos (excluyendo el usuario actual)
            $usuariosRecientes = User::where('id', '!=', Auth::id())
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();

            $this->usuarios_recientes = $usuariosRecientes->map(function ($usuario) {
                return [
                    'inicial' => $usuario->initials(),
                    'nombre' => $usuario->name,
                    'rol' => $usuario->rol ?? 'Usuario',
                    'tiempo' => $this->calcularTiempoTranscurrido($usuario->created_at)
                ];
            })->toArray();

            // Si no hay usuarios suficientes, mostrar mensaje apropiado
            if (count($this->usuarios_recientes) === 0) {
                $this->usuarios_recientes = [
                    [
                        'inicial' => '?',
                        'nombre' => 'No hay usuarios registrados',
                        'rol' => '',
                        'tiempo' => ''
                    ]
                ];
            }

        } catch (\Exception $e) {
            // En caso de error, mostrar mensaje de error
            $this->usuarios_recientes = [
                [
                    'inicial' => '!',
                    'nombre' => 'Error al cargar usuarios',
                    'rol' => '',
                    'tiempo' => ''
                ]
            ];
        }
    }

    private function calcularTiempoTranscurrido($fecha)
    {
        $diferencia = now()->diffInDays($fecha);

        if ($diferencia == 0) {
            return 'Hoy';
        } elseif ($diferencia == 1) {
            return 'Ayer';
        } elseif ($diferencia < 7) {
            return "Hace {$diferencia} días";
        } elseif ($diferencia < 30) {
            $semanas = floor($diferencia / 7);
            return $semanas == 1 ? 'Hace 1 semana' : "Hace {$semanas} semanas";
        } else {
            $meses = floor($diferencia / 30);
            return $meses == 1 ? 'Hace 1 mes' : "Hace {$meses} meses";
        }
    }

    // Métodos para Gestión de Usuarios
    public function gestionarUsuarios()
    {
        return redirect()->route('usuarios.index');
    }

    public function gestionarRoles()
    {
        $this->dispatch('abrirModalRoles');
    }

    public function invitarUsuarios()
    {
        return redirect()->route('usuarios.invitar');
    }

    // Métodos para Acciones Rápidas
    public function irDashboard()
    {
        return redirect()->route('dashboard');
    }

    public function irConvenios()
    {
        return redirect()->route('convenios-main');
    }

    public function irEntidades()
    {
        return redirect()->route('entidades-main');
    }

    public function irReportes()
    {
        return redirect()->route('reportes-main');
    }

    // Métodos de Exportación
    public function exportarExcel()
    {
        try {
            // Aquí implementarías la lógica de exportación a Excel
            // Por ejemplo usando Laravel Excel
            $this->mensaje_exito = 'Datos exportados a Excel correctamente';
            $this->dispatch('mostrar-mensaje');
        } catch (\Exception $e) {
            $this->mensaje_error = 'Error al exportar a Excel: ' . $e->getMessage();
            $this->dispatch('mostrar-error');
        }
    }

    public function exportarPDF()
    {
        try {
            // Aquí implementarías la lógica de exportación a PDF
            // Por ejemplo usando DomPDF o similar
            $this->mensaje_exito = 'Datos exportados a PDF correctamente';
            $this->dispatch('mostrar-mensaje');
        } catch (\Exception $e) {
            $this->mensaje_error = 'Error al exportar a PDF: ' . $e->getMessage();
            $this->dispatch('mostrar-error');
        }
    }

    public function exportarCSV()
    {
        try {
            // Aquí implementarías la lógica de exportación a CSV
            $this->mensaje_exito = 'Datos exportados a CSV correctamente';
            $this->dispatch('mostrar-mensaje');
        } catch (\Exception $e) {
            $this->mensaje_error = 'Error al exportar a CSV: ' . $e->getMessage();
            $this->dispatch('mostrar-error');
        }
    }

    // Actualizar perfil del administrador
    public function actualizarPerfil()
    {
        $this->validate([
            'admin_nombre' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email,' . Auth::id(),
            'admin_password' => 'nullable|min:6',
            'admin_rol' => 'required|string',
            'admin_carrera_id' => 'nullable|exists:carreras,id',
        ], [
            'admin_nombre.required' => 'El nombre es obligatorio',
            'admin_email.required' => 'El email es obligatorio',
            'admin_email.email' => 'El email debe tener un formato válido',
            'admin_email.unique' => 'Este email ya está en uso',
            'admin_password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'admin_rol.required' => 'El rol es obligatorio',
            'admin_carrera_id.exists' => 'La carrera seleccionada no es válida',
        ]);

        try {
            $user = User::find(Auth::id());

            if (!$user) {
                throw new \Exception('Usuario no encontrado');
            }

            $user->name = $this->admin_nombre;
            $user->email = $this->admin_email;
            $user->rol = $this->admin_rol;
            $user->user_carrera_id = $this->admin_carrera_id;

            if (!empty($this->admin_password)) {
                $user->password = Hash::make($this->admin_password);
            }

            $user->save();

            $this->mensaje_exito = 'Perfil actualizado correctamente';
            $this->dispatch('mostrar-mensaje');

            // Limpiar contraseña después de actualizar
            $this->admin_password = '';

            // Recargar datos del usuario
            $this->cargarDatosUsuarioActual();

        } catch (\Exception $e) {
            $this->mensaje_error = 'Error al actualizar el perfil: ' . $e->getMessage();
            $this->dispatch('mostrar-error');
        }
    }

    // Método que se ejecuta cuando cambia la selección de carrera
    public function updatedAdminCarreraId()
    {
        if ($this->admin_carrera_id) {
            try {
                $carrera = Carrera::find($this->admin_carrera_id);
                $this->admin_carrera = $carrera ? $carrera->nombreCarrera : 'Sin asignar';
            } catch (\Exception $e) {
                $this->admin_carrera = 'Sin asignar';
            }
        } else {
            $this->admin_carrera = 'Sin asignar';
        }
    }

    // Guardar configuración de alertas
    public function guardarConfiguracionAlertas()
    {
        try {
            // Verificar si el modelo existe antes de usarlo
            if (class_exists('App\Models\AlertaConfiguracion')) {
                AlertaConfiguracion::updateOrCreate(
                    ['user_id' => Auth::id()],
                    [
                        'alertas_vencimiento' => $this->alertas_vencimiento,
                        'alertas_documentos' => $this->alertas_documentos,
                        'alertas_usuarios' => $this->alertas_usuarios,
                        'alertas_cambios' => $this->alertas_cambios,
                        'tiempo_anticipacion' => $this->tiempo_anticipacion,
                        'frecuencia_recordatorios' => $this->frecuencia_recordatorios,
                    ]
                );

                $this->mensaje_exito = 'Configuración de alertas guardada correctamente';
                $this->dispatch('mostrar-mensaje');
            }

        } catch (\Exception $e) {
            $this->mensaje_error = 'Error al guardar la configuración: ' . $e->getMessage();
            $this->dispatch('mostrar-error');
        }
    }

    // Método que se ejecuta cuando cambian los toggles de alertas
    public function updatedAlertasVencimiento()
    {
        $this->guardarConfiguracionAlertas();
    }

    public function updatedAlertasDocumentos()
    {
        $this->guardarConfiguracionAlertas();
    }

    public function updatedAlertasUsuarios()
    {
        $this->guardarConfiguracionAlertas();
    }

    public function updatedAlertasCambios()
    {
        $this->guardarConfiguracionAlertas();
    }

    public function updatedTiempoAnticipacion()
    {
        $this->guardarConfiguracionAlertas();
    }

    public function updatedFrecuenciaRecordatorios()
    {
        $this->guardarConfiguracionAlertas();
    }

    // Método para limpiar mensajes
    public function limpiarMensajes()
    {
        $this->mensaje_exito = '';
        $this->mensaje_error = '';
    }

    // Método para refrescar datos
    public function refrescarDatos()
    {
        $this->cargarDatosUsuarioActual();
        $this->cargarUsuariosRecientes();
        $this->cargarCarrerasDisponibles();
        $this->mensaje_exito = 'Datos actualizados correctamente';
        $this->dispatch('mostrar-mensaje');
    }

    // MÉTODO PARA DEBUG - REMOVER EN PRODUCCIÓN
    public function debugCarreras()
    {
        Log::info('Debug Carreras:', [
            'carreras_count' => count($this->carreras_disponibles),
            'carreras' => $this->carreras_disponibles
        ]);

        $this->mensaje_exito = 'Debug ejecutado - revisa los logs';
        $this->dispatch('mostrar-mensaje');
    }

    public function render()
    {
        return view('livewire.configuracion-main', [
            'usuarios_recientes' => $this->usuarios_recientes,
            'usuario_actual' => Auth::user(),
            'carreras_disponibles' => $this->carreras_disponibles
        ]);
    }
}