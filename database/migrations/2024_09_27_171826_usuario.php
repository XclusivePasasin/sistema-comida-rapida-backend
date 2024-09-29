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
        Schema::create('USUARIO', function (Blueprint $table) {
            $table->id('ID_USUARIO');
            $table->string('USUARIO', 255);
            $table->string('CONTRASEÑA', 255);
            $table->string('ROL', 50);
            $table->string('NOMBRE_EMPLEADO', 255);
            $table->string('TELEFONO', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('USUARIO');
    }
};
