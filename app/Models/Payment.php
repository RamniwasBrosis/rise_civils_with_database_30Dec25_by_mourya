<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'amount',
        'transaction_id',
        'payment_status',
        'response_msg',
        'providerReferenceId',
        'merchantOrderId',
        'checksum',
        'order_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to OrderConfirm
    public function order()
    {
        return $this->belongsTo(orders_confirm::class, 'order_id');
    }
}
