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
        if (!Schema::hasTable('PLATILLO')) {
            Schema::create('PLATILLO', function (Blueprint $table) {
                $table->id('ID_PLATILLO');
                $table->string('NOMBRE_PLATILLO');
                $table->float('PRECIO');
                $table->string('DESCRIPCION')->nullable();
                $table->foreignId('ID_CATEGORIA')->constrained('CATEGORIA', 'ID_CATEGORIA')->onDelete('cascade');
        
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PLATILLO');
    }
};
