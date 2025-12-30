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
        Schema::create('table_types', function (Blueprint $table) {
            $table->id();
            
            $table->string('type');
            $table->integer('order_no');
            $table->string('order_no')->nullable();
            $table->text('order_no')->nullable();
            $table->longText('order_no')->nullable();
            $table->enum('status', ['1', '0']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_rise_types');
    }
};
