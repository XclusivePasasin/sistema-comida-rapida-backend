<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->increments('id_table');
            $table->string('table_number', 4);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
    
};
