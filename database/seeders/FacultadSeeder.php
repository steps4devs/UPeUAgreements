<?php

namespace Database\Seeders;

use App\Models\Facultad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        Facultad::create([
            'nombreFacultad'=>"Facultad de Ingeniería y Arquitectura"
        ]);
        Facultad::create([
            'nombreFacultad'=>"Facultad de Ciencias de la Salud"
        ]);
        Facultad::create([
            'nombreFacultad'=>"Facultad de Ciencias Humanas y Educación"
        ]);
        Facultad::create([
            'nombreFacultad'=>"Facultad de Ciencias Empresariales"
        ]);
    
    }
}
