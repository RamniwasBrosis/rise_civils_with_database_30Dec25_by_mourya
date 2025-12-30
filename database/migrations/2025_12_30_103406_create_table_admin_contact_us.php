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
        Schema::create('admin_contact_us', function (Blueprint $table) {
            $table->id();
        
            $table->string('title')->nullable();
            $table->text('description')->nullable();
        
            $table->text('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
        
            $table->tinyInteger('status')->default(1)
                  ->comment('1 = Active, 0 = Inactive');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_contact_us');
    }
};
