<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id_order');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->dateTime('order_date');
            $table->string('customer_dui', 10);
            $table->foreign('customer_dui')->references('dui')->on('customers')->onDelete('cascade');
            $table->unsignedInteger('id_table');
            $table->foreign('id_table')->references('id_table')->on('tables')->onDelete('cascade');
            $table->char('status', 1);
            $table->float('total');
            $table->string('payment_method', 40);
            
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
    
};
