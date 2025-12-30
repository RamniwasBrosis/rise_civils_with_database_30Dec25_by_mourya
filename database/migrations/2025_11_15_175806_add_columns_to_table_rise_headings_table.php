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
        Schema::table('table_rise_headings', function (Blueprint $table) {
            $table->string('image')->nullable()->after('slug');
            $table->enum('isFeatured', ['0', '1'])->default('0')->after('image');
            $table->text('content')->nullable()->after('isFeatured');
            $table->text('description')->nullable()->change(); // if you want to keep existing description
            $table->text('link')->nullable()->after('content');
            $table->string('title')->nullable()->after('link');
            $table->unsignedBigInteger('heading_id')->nullable()->after('id');

            // Foreign key referencing its own table
            $table->foreign('heading_id')->references('id')->on('table_rise_headings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table_rise_headings', function (Blueprint $table) {
            $table->dropForeign(['heading_id']);
            $table->dropColumn([
                'image',
                'isFeatured',
                'content',
                'link',
                'title',
                'heading_id',
            ]);
        });
    }
};
