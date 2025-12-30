<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('ticket_bookings', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->date('date'); // Booking date
            $table->string('user_id'); // Time slot
            $table->string('time'); // Time slot
            $table->json('ticket_qty'); // Store ticket quantities as JSON
            $table->string('coupon_code'); // Store ticket quantities as JSON
            $table->string('discount_amount'); // Store ticket quantities as JSON
            $table->string('gst_amount'); // Store ticket quantities as JSON
            $table->timestamps(); // Created at and Updated at
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_bookings');
    }
}
