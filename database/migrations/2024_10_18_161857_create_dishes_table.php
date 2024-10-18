<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('dishes', function (Blueprint $table) {
            $table->increments('id_dish');
            $table->string('dish_name', 50);
            $table->float('price');
            $table->string('description', 255)->nullable();
            $table->unsignedInteger('id_category');
            $table->foreign('id_category')->references('id_category')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dishes');
    }
};
