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
        Schema::create('page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 20)->nullable();
            $table->string('whatapp_number', 20)->nullable();
            $table->string('email', 80)->nullable();
            $table->string('address', 180)->nullable();
            $table->string('logo_image', 150)->nullable();
            
            $table->string('aboutus_content', 255)->nullable();
            
            $table->string('pinsert_url', 100)->nullable();
            $table->string('facebook_url', 100)->nullable();
            $table->string('twitter_url', 100)->nullable();
            $table->string('instagram_url', 100)->nullable();
            $table->string('youtube_url', 200)->nullable();
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_settings');
    }
};
