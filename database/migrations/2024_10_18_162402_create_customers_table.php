<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('dui', 10)->primary();
            $table->string('first_name', 70);
            $table->string('last_name', 70);
            $table->string('address', 255);
            $table->string('phone', 8);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
