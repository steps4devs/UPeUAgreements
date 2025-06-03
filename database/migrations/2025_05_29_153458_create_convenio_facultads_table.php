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
        Schema::create('convenio_facultads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("conveniofac_id_convenio");
            $table->foreign("conveniofac_id_convenio")->references("id")->on("convenios")->onDelete("cascade");
            $table->unsignedBigInteger("conveniofac_id_facultad");
            $table->foreign("conveniofac_id_facultad")->references("id")->on("facultads")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenio_facultads');
    }
};
