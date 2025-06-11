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
        // 1. Crear Facultades (puedes usar el seeder existente o aquí mismo)
        $facultad = Facultad::create([
            'nombreFacultad' => 'Facultad de Ingeniería y Arquitectura'
        ]);

        // 2. Crear Carreras asociadas a la facultad
        $carrera = Carrera::create([
            'nombreCarrera' => 'Ingeniería de Sistemas',
            'facultad_id' => $facultad->id,
        ]);

        // 3. Crear un usuario administrador asociado a la carrera
        User::factory()->create([
            'name' => 'gian',
            'email' => 'gluck.pastor@gmail.com',
            'password' => bcrypt('12345678'),
            'rol' => 'Administrador',
            'user_carrera_id' => $carrera->id,
        ]);

        // 4. Si quieres más usuarios de prueba:
        User::factory(5)->create([
            'user_carrera_id' => $carrera->id,
            'rol' => 'Coordinador',
        ]);

        // 5. Llama a otros seeders si los tienes
        $this->call(FacultadSeeder::class);
    }
}
