<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Facultad;
use App\Models\Carrera;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Facultad de Ciencias Empresariales (FCE)
        $fce = Facultad::firstOrCreate(['nombreFacultad' => 'Facultad de Ciencias Empresariales']);
        $fce_carreras = [
            'Contabilidad',
            'Administración de Empresas',
        ];
        foreach ($fce_carreras as $nombreCarrera) {
            Carrera::firstOrCreate([
                'nombreCarrera' => $nombreCarrera,
                'facultad_id' => $fce->id,
            ]);
        }

        // 2. Facultad de Ciencias de la Salud (FCS)
        $fcs = Facultad::firstOrCreate(['nombreFacultad' => 'Facultad de Ciencias de la Salud']);
        $fcs_carreras = [
            'Enfermería',
            'Psicología',
            'Nutrición Humana',
            'Medicina Humana', // Solo sede central
            'Odontología',     // Solo sede central
        ];
        foreach ($fcs_carreras as $nombreCarrera) {
            Carrera::firstOrCreate([
                'nombreCarrera' => $nombreCarrera,
                'facultad_id' => $fcs->id,
            ]);
        }

        // 3. Facultad de Ingeniería y Arquitectura (FIA)
        $fia = Facultad::firstOrCreate(['nombreFacultad' => 'Facultad de Ingeniería y Arquitectura']);
        $fia_carreras = [
            'Ingeniería de Sistemas',
            'Ingeniería Ambiental',
            'Arquitectura',
            'Ingeniería Civil',
            'Ingeniería Industrial',
        ];
        foreach ($fia_carreras as $nombreCarrera) {
            Carrera::firstOrCreate([
                'nombreCarrera' => $nombreCarrera,
                'facultad_id' => $fia->id,
            ]);
        }

        // 4. Facultad de Ciencias Humanas y Educación (FCHE)
        $fche = Facultad::firstOrCreate(['nombreFacultad' => 'Facultad de Ciencias Humanas y Educación']);
        $fche_carreras = [
            'Educación Inicial',
            'Educación Primaria',
            'Educación Secundaria en Matemática y Física',
            'Educación Secundaria en Comunicación y Ciencias Sociales',
            'Educación Secundaria en Inglés',
        ];
        foreach ($fche_carreras as $nombreCarrera) {
            Carrera::firstOrCreate([
                'nombreCarrera' => $nombreCarrera,
                'facultad_id' => $fche->id,
            ]);
        }

        // Usuario de ejemplo (asociado a Ingeniería de Sistemas)
        $carreraEjemplo = Carrera::where('nombreCarrera', 'Ingeniería de Sistemas')->first();
        if ($carreraEjemplo) {
            User::factory()->create([
                'name' => 'ladrix',
                'email' => 'ladrix@gmail.com',
                'password' => bcrypt('12345678'),
                'rol' => 'Administrador',
                'user_carrera_id' => $carreraEjemplo->id,
            ]);
            User::factory(5)->create([
                'user_carrera_id' => $carreraEjemplo->id,
                'rol' => 'Coordinador',
            ]);
        }
    }
}
