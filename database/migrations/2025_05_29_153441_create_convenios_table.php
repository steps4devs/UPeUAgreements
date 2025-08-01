<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('convenios', function (Blueprint $table) {
            $table->id();
            $table->string("nombreConvenio");
            $table->string('descripcion')->nullable(); 
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable(); 
            $table->enum('estado',['Vigente', 'Vencido', 'Por vencer']);
            $table->enum('alcance',['Carrera', 'Facultad', 'Universidad']);
            $table->unsignedBigInteger("convenio_creador");
            $table->foreign("convenio_creador")->references("id")->on("users")->onDelete("cascade");
            $table->unsignedBigInteger("convenio_id_entidad");
            $table->foreign("convenio_id_entidad")->references("id")->on("entidads")->onDelete("cascade");
            $table->unsignedBigInteger('facultad_id')->nullable();
            $table->foreign('facultad_id')->references('id')->on('facultads')->onDelete('cascade');
            $table->unsignedBigInteger('carrera_id')->nullable();
            $table->foreign('carrera_id')->references('id')->on('carreras')->onDelete('cascade');

            $table->enum('ambito_1', [
                'Investigación', 'Prácticas Profesionales', 'Transferencia Tecnológica', 'Movilidad Académica',
                'Capacitación', 'Desarrollo de Proyectos', 'Intercambio Cultural', 'Responsabilidad Social',
                'Innovación', 'Emprendimiento', 'Servicios Tecnológicos', 'Consultoría', 'Educación Continua',
                'Desarrollo Sostenible', 'Vinculación Empresarial', 'Internacionalización', 'Publicaciones',
                'Eventos Académicos', 'Otros'
            ])->nullable();
            $table->enum('ambito_2', [
                'Investigación', 'Prácticas Profesionales', 'Transferencia Tecnológica', 'Movilidad Académica',
                'Capacitación', 'Desarrollo de Proyectos', 'Intercambio Cultural', 'Responsabilidad Social',
                'Innovación', 'Emprendimiento', 'Servicios Tecnológicos', 'Consultoría', 'Educación Continua',
                'Desarrollo Sostenible', 'Vinculación Empresarial', 'Internacionalización', 'Publicaciones',
                'Eventos Académicos', 'Otros'
            ])->nullable();
            $table->enum('ambito_3', [
                'Investigación', 'Prácticas Profesionales', 'Transferencia Tecnológica', 'Movilidad Académica',
                'Capacitación', 'Desarrollo de Proyectos', 'Intercambio Cultural', 'Responsabilidad Social',
                'Innovación', 'Emprendimiento', 'Servicios Tecnológicos', 'Consultoría', 'Educación Continua',
                'Desarrollo Sostenible', 'Vinculación Empresarial', 'Internacionalización', 'Publicaciones',
                'Eventos Académicos', 'Otros'
            ])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenios');
    }
};
