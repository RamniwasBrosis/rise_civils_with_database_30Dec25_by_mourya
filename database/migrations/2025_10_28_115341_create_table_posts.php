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
        Schema::create('table_posts', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');
            $table->text('description');
            $table->text('content');
            $table->text('image');
            $table->text('pdf')->nullable();
            $table->foreignId('category_id')->constrained('table_rise_categories');
            $table->enum('status', ['1', '0']);
            $table->text('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_posts');
    }
};
