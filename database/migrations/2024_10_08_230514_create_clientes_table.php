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
        Schema::create('CLIENTE', function (Blueprint $table) {
            $table->string('DUI', 10)->primary();
            $table->string('NOMBRE', 255);
            $table->string('APELLIDO', 255);
            $table->string('DIRECCION', 255);
            $table->string('TELEFONO', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CLIENTE');
    }
};
