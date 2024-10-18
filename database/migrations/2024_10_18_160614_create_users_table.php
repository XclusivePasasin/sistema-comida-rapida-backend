<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('password', 255);
            $table->char('role', 1);
            $table->string('username', 15);
            $table->string('employee_name', 70);
            $table->string('phone', 8);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
