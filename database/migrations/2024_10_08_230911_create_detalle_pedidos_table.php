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
        if (!Schema::hasTable('DETALLE_PEDIDO')) {
            Schema::create('DETALLE_PEDIDO', function (Blueprint $table) {
                $table->id('ID_DETALLE_PEDIDO');
                $table->foreignId('ID_PLATILLO')->constrained('PLATILLO', 'ID_PLATILLO')->onDelete('cascade');
                $table->foreignId('ID_PEDIDO')->constrained('PEDIDO', 'ID_PEDIDO')->onDelete('cascade');
                $table->integer('CANTIDAD');
                $table->float('SUBTOTAL');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DETALLE_PEDIDO');
    }
};
