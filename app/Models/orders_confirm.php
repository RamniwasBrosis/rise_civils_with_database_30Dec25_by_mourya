<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders_confirm extends Model
{
    protected $table = 'orders_confirm';
    protected $fillable = [
        'user_id',
        'name',
        'last_name',
        'user_email',
        'user_phone',
        'ticket_no',
        'total_amount',
        'time',
        'date',
        'ticketQty',
        'status',
        'coupans_code',
        'coupans_discount',
        'ticket_booking_id',
        'role',
        'last_print_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticketBooking()
    {
        return $this->belongsTo(TicketBooking::class, 'ticket_booking_id', 'id');
    }
}
