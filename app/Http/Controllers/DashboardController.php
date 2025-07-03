<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\Entidad;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->rol, ['Secretaria', 'Coordinador'])) {
            $carreraId = $user->user_carrera_id;
            $facultadId = optional($user->carrera)->facultad_id;

            $convenios = Convenio::with('facultad', 'entidad')
                ->where(function ($q) use ($carreraId, $facultadId) {
                    $q->where(function ($q2) {
                        $q2->whereNull('facultad_id')->whereNull('carrera_id'); // Convenios generales (universidad)
                    })
                    ->orWhere(function ($q2) use ($facultadId) {
                        $q2->where('facultad_id', $facultadId)->whereNull('carrera_id'); // De su facultad
                    })
                    ->orWhere('carrera_id', $carreraId); // De su carrera
                })
                ->get();
        } else {
            // Administrador ve todos
            $convenios = Convenio::with('facultad', 'entidad')->get();
        }

        $totalConvenios = $convenios->count();
        $conveniosActivos = $convenios->where('estado', 'Vigente')->count();
        $porVencer = $convenios->where('estado', 'Por vencer')->count();
        $entidadesAsociadas = Entidad::count();

        $porcentajeActivos = $totalConvenios > 0
            ? round(($conveniosActivos / $totalConvenios) * 100, 2)
            : 0;

        $facultades = $convenios->whereNotNull('facultad_id')
            ->groupBy('facultad_id')
            ->map(function ($item) {
                return [
                    'facultad' => $item->first()->facultad->nombreFacultad ?? 'Sin Facultad',
                    'total' => $item->count(),
                ];
            })->values(); // <-- importante para que sea un array indexado

        $ultimosConvenios = $convenios->sortByDesc('created_at')->take(10);

        return view('dashboard', [
            'facultades' => $facultades,
            'totalConvenios' => $totalConvenios,
            'conveniosActivos' => $conveniosActivos,
            'porVencer' => $porVencer,
            'entidadesAsociadas' => $entidadesAsociadas,
            'porcentajeActivos' => $porcentajeActivos,
            'ultimosConvenios' => $ultimosConvenios,
            'convenios' => $convenios
        ]);
    }
}