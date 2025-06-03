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
