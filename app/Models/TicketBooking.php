<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketBooking extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'date', 'time', 'user_id', 'ticket_qty', 'coupon_code', 'discount_amount', 'gst_amount'];

    // Cast ticket_qty as an array
    protected $casts = [
        'ticket_qty' => 'array',
    ];

    public function orderConfirm()
    {
        return $this->hasMany(orders_confirm::class);
    }
}
