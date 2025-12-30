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
        Schema::table('orders_confirm', function (Blueprint $table) {
            $table->date('date');
            $table->time('time');
            $table->string('mobile_1');
            $table->string('mobile_2');
            $table->string('mobile_3');
            $table->string('mobile_4');
            $table->string('contact_person_1');
            $table->string('contact_person_2');
            $table->string('contact_person_3');
            $table->string('contact_person_4');
            $table->string('role');
            $table->string('reference');
            $table->string('gst');
            $table->string('payment_type');
            $table->string('ticket_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders_confirm', function (Blueprint $table) {
            $table->dropColumn([
                'date',
                'time',
                'mobile_1',
                'mobile_2',
                'mobile_3',
                'mobile_4',
                'contact_person_1',
                'contact_person_2',
                'contact_person_3',
                'contact_person_4',
                'role',
                'reference',
                'gst',
                'payment_type',
                'ticket_type'
            ]);
        });
    }
};
