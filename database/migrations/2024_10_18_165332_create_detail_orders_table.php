<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->increments('id_order_detail');
            $table->unsignedInteger('id_dish');
            $table->foreign('id_dish')->references('id_dish')->on('dishes')->onDelete('cascade');
            $table->unsignedInteger('id_order');
            $table->foreign('id_order')->references('id_order')->on('orders')->onDelete('cascade');
            $table->integer('quantity');
            $table->float('subtotal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_orders');
    }
};
