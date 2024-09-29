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
        if (!Schema::hasTable('PEDIDO')) {
            Schema::create('PEDIDO', function (Blueprint $table) {
                $table->id('ID_PEDIDO');
        
                // Clave foránea hacia 'USUARIO' referenciando 'ID_USUARIO'
                $table->foreignId('ID_USUARIO')->constrained('USUARIO', 'ID_USUARIO')->onDelete('cascade');
        
                $table->string('FECHA', 50);
        
                // Clave foránea hacia 'CLIENTE' referenciando 'DUI'
                $table->string('DUI_CLIENTE', 10);
                $table->foreign('DUI_CLIENTE')->references('DUI')->on('CLIENTE')->onDelete('cascade');
        
                // Clave foránea hacia 'MESA' referenciando 'ID_MESA'
                $table->foreignId('ID_MESA')->constrained('MESA', 'ID_MESA')->onDelete('cascade');
        
                $table->string('ESTADO', 50);
                $table->float('TOTAL');
                $table->string('PAGO', 50);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PEDIDO');
    }
};
