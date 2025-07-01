<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\Entidad;

class DashboardController extends Controller
{
    public function index()
    {
        $totalConvenios = Convenio::count();
        $conveniosActivos = Convenio::where('estado', 'Vigente')->count();
        $porVencer = Convenio::where('estado', 'Por vencer')->count();
        $entidadesAsociadas = Entidad::count();

        // Calcular el porcentaje de convenios activos
        $porcentajeActivos = $totalConvenios > 0 ? round(($conveniosActivos / $totalConvenios) * 100, 2) : 0;

        // Calcular la distribución por facultad
        $facultades = Convenio::selectRaw('facultad_id, COUNT(*) as total')
            ->groupBy('facultad_id')
            ->with('facultad')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->facultad->nombreFacultad ?? 'Otros' => $item->total];
            });

        // Cargar los últimos convenios
        $ultimosConvenios = Convenio::with(['entidad', 'facultad'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalConvenios',
            'conveniosActivos',
            'porVencer',
            'entidadesAsociadas',
            'porcentajeActivos',
            'facultades',
            'ultimosConvenios'
        ));
    }
}
