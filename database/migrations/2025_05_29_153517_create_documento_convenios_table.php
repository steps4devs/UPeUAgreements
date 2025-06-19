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
        Schema::create('documento_convenios', function (Blueprint $table) {
            $table->id();
            $table->string("nombreArchivo");
            $table->enum('tipo_documento',['PDF', 'Imagen', 'Otro']);
            $table->date('fecha_subida');
            $table->time('hora_subida');
            $table->unsignedBigInteger("convenio_id");
            $table->foreign("convenio_id")->references("id")->on("convenios")->onDelete("cascade");
            $table->string('ruta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento_convenios');
    }
};
