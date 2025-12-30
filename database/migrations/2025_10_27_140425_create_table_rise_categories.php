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
        Schema::create('table_rise_categories', function (Blueprint $table) {
            $table->id();
    
            $table->string('name');
            
            $table->foreignId('type_id')
                  ->constrained('table_types') 
                  ->cascadeOnDelete(); 
            
            $table->enum('status', ['1', '0']);
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_rise_categories');
    }
};
